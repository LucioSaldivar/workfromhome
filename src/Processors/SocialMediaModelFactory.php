<?php
declare(strict_types=1);

namespace SocialApp\Processors;

use SocialApp\Model\SocialMediaModel;

class SocialMediaModelFactory
{
    public function createObjectClass(array $item): SocialMediaModel
    {
        $model = new SocialMediaModel();
        $model->setId($item['id']);
        $model->setTitle($item['title']);
        $model->setUrl($item['url']);

        return $model;
    }
}