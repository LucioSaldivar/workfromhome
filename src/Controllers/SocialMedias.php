<?php
declare(strict_types=1);

namespace SocialApp\Controllers;

use Exception;
use SocialApp\Processors\MyException;
use SocialApp\Repositories\SocialMediaRepository;
use SocialApp\views\ListView\SocialMediaAll;
use Psr\Http\Message\ResponseInterface;

class SocialMedias
{
    private ResponseInterface $response;

    private SocialMediaRepository $repository;

    private SocialMediaAll $socialViews;

    public function __construct(
        ResponseInterface $response,
        SocialMediaRepository $repository,
        SocialMediaAll $socialViews
    )
    {
        $this->response = $response;
        $this->repository = $repository;
        $this->socialViews = $socialViews;
    }

    public function __invoke(): ResponseInterface
    {
        try {
            $socialModels = $this->repository->getAll();
            $result = $this->socialViews->getHtml($socialModels);
        } catch (MyException | Exception $ex) {
            $result = "Failed to get list of Social Medias";
        } finally {
            $result = "None of they catches worked, wow -_-";
        }

        $response = $this->response->withHeader('Content-Type', 'text/html');
        $response->getBody()
            ->write($result);

        return $response;
    }
}