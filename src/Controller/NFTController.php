<?php

namespace App\Controller;

use App\Entity\NFT;
use App\Form\NFTType;
use App\Repository\NFTRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/nft')]
class NFTController extends AbstractController
{
    #[Route('/', name: 'app_nft_index', methods: ['GET'])]
    public function index(NFTRepository $nFTRepository): Response
    {
        return $this->render('nft/index.html.twig', [
            'nfts' => $nFTRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_nft_new', methods: ['GET', 'POST'])]
    public function new(Request $request, NFTRepository $nFTRepository): Response
    {
        $nFT = new NFT();
        $form = $this->createForm(NFTType::class, $nFT);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $nFTRepository->save($nFT, true);

            return $this->redirectToRoute('app_nft_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('nft/new.html.twig', [
            'nft' => $nFT,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_nft_show', methods: ['GET'])]
    public function show(NFT $nFT): Response
    {
        return $this->render('nft/show.html.twig', [
            'nft' => $nFT,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_nft_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, NFT $nFT, NFTRepository $nFTRepository): Response
    {
        $form = $this->createForm(NFTType::class, $nFT);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $nFTRepository->save($nFT, true);

            return $this->redirectToRoute('app_nft_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('nft/edit.html.twig', [
            'n_f_t' => $nFT,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_nft_delete', methods: ['POST'])]
    public function delete(Request $request, NFT $nFT, NFTRepository $nFTRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $nFT->getId(), $request->request->get('_token'))) {
            $nFTRepository->remove($nFT, true);
        }

        return $this->redirectToRoute('app_nft_index', [], Response::HTTP_SEE_OTHER);
    }
}
