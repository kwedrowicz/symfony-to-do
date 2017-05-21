vcl 4.0;

backend default {
    .host = "127.0.0.1";
    .port = "80";
}

sub vcl_recv {
    unset req.http.Forwarded;
    unset req.http.Cookie;
}

sub vcl_backend_response {
    unset beresp.http.set-cookie;
}