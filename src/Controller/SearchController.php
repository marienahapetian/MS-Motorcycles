<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SearchController extends AbstractController
{
    #[Route('/search', name: 'search_results')]
    public function search(
        Request $request,
        ProductRepository $products,
        PaginatorInterface $paginator
    ): Response {
        $query = $request->query->get('q', '');

        $qb = $products->searchQueryBuilder($query);

        $pagination = $paginator->paginate(
            $qb,
            $request->query->getInt('page', 1)
        );

        return $this->render('search/results.html.twig', [
            'query' => $query,
            'products' => $pagination,
            'data' => $pagination
        ]);
    }
}
