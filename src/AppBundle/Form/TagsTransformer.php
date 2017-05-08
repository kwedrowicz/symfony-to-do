<?php


namespace AppBundle\Form;

use AppBundle\Entity\Tag;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;

class TagsTransformer implements DataTransformerInterface
{
    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }


    public function transform($tags)
    {
        /* @var ArrayCollection|Tag[] $tags */
        $tagsArray = [];
        foreach($tags as $tag){
            $tagsArray[] = $tag->getName();
        }
        if(!$tags){
            return '';
        }
        return implode(', ',$tagsArray);
    }

    public function reverseTransform($tagsAsString)
    {
        $tagNames = explode(', ', $tagsAsString);
        $collection = new ArrayCollection();
        foreach($tagNames as $name){
            $tag = $this->manager->getRepository('AppBundle:Tag')->findOneBy(['name' => $name]);
            if(!$tag){
                $tag = new Tag();
                $tag->setName($name);
            }
            $collection->add($tag);
        }
        return $collection;
    }
}
