<?php
declare(strict_types=1);

namespace SocialApp\Repositories;

use SocialApp\Model\SocialMediaModel;
use SocialApp\Processors\SocialMediaModelFactory;

class SocialMediaRepository
{
    private SocialMediaModelFactory $factory;

    const SOCIALDATA = [
        [
            'id' => '1',
            'title' => 'twitter',
            'url' => 'www.twitter.com',
        ],
        [
            'id' => '2',
            'title' => 'facebook',
            'url' => 'www.facebook.com',
        ],
        [
            'id' => '3',
            'title' => 'instagram',
            'url' => 'www.instagram.com',
        ],
    ];

    public function __construct( SocialMediaModelFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        $result = [];
        foreach (self::SOCIALDATA as $item) {
            $result[] =$this->factory->createObjectClass($item) ;
        }
        return $result;
    }

    /**
     * @param string $id
     * @return SocialMediaModel
     * @throws \Exception
     */
    public function getById(string $id): SocialMediaModel
    {
        foreach ($this->getAll() as $item){
            if($item->getId() == $id){
                return $item;
            }
        }
        throw new \Exception('Cant find Social Media.');
    }

    /**
     * @param string $title
     * @return SocialMediaModel
     * @throws \SocialApp\Processors\MyException
     */
    public function getByTitle(string $title): SocialMediaModel
    {
        foreach ($this->getAll() as $item){
            if($item->getTitle() == $title){
                return $item;
            }
        }
        throw new \SocialApp\Processors\MyException('Cant find Social Media.');
    }



//    public function save()
//    {
//
//}
//
//    public function delete()
//    {
//
//}

}