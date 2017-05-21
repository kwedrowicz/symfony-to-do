vcl 4.0;

backend default {
    .host = "127.0.0.1";
    .port = "80";
}

sub vcl_recv {
    # Happens before we check if we have this in cache already.
    #
    # Typically you clean up the request here, removing cookies you don't need,
    # rewriting the request, etc.
    unset req.http.Forwarded;
    if (req.http.X-Forwarded-Proto == "https" ) {
            set req.http.X-Forwarded-Port = "443";
    } else {
            set req.http.X-Forwarded-Port = "80";
    }

    if (req.http.Cookie) {
        if ( req.url ~ "^/news/" ) {
            unset req.http.Cookie;
        }
    }

    if (req.method == "PURGE") {
        if (!client.ip ~ invalidators) {
            return (synth(405, "Not allowed"));
        }
        return (purge);
    }

    if (req.http.Cache-Control ~ "no-cache" && client.ip ~ invalidators) {
        set req.hash_always_miss = true;
    }
}

acl invalidators {
    "localhost";
}

sub vcl_deliver {
    # Add extra headers if debugging is enabled
    # In Varnish 4 the obj.hits counter behaviour has changed, so we use a
    # different method: if X-Varnish contains only 1 id, we have a miss, if it
    # contains more (and therefore a space), we have a hit.
    if (resp.http.X-Cache-Debug) {
        if (resp.http.X-Varnish ~ " ") {
            set resp.http.X-Cache = "HIT";
        } else {
            set resp.http.X-Cache = "MISS";
        }
    }
}