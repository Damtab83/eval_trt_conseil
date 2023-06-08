<?php

namespace App\Controller;

use App\Entity\Notice;
use App\Form\NoticeType;
use App\Repository\NoticeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class NoticeController extends AbstractController
{
    /**
     *This controller display all notice
     *
     * @param NoticeRepository $noticeRepository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    #[Route('/notice', name: 'app_notice')]
    public function index(NoticeRepository $noticeRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $notices = $paginator->paginate(
            $noticeRepository->findBy(['recruteur' => $this->getUser()]),
            $request->query->getInt('page', 1),
            9
        );

        return $this->render('notice/index.html.twig', [
            'notices' => $notices
        ]);
    }

    /**
     * This controller shows how to create a notice
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('notice/new', 'notice.new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $manager) : Response
    {
        $notice = new Notice();
        $form =$this->createForm(NoticeType::class, $notice);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $notice = $form->getData();
            $notice->setRecruteur($this->getUser());

            $manager->persist($notice);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre annonce a été créée avec succès ! '
            );

            return $this->redirectToRoute('app_notice');
        }

        return $this->render('/notice/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('notice/edit/{id}', 'notice.edit', methods: ['GET', 'POST'])]
    public function edit(Notice $notice, Request $request, EntityManagerInterface $manager) : Response
    {
        $form =$this->createForm(NoticeType::class, $notice);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $notice = $form->getData();

            $manager->persist($notice);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre annonce a été modifiée avec succès ! '
            );

            return $this->redirectToRoute('app_notice');
        }

        return $this->render('/notice/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/notice/delete/{id}', 'notice.delete', methods: ['GET'])]
    public function delete(EntityManagerInterface $manager, Notice $notice) : Response
    {
        $manager->remove($notice);
        $manager->flush();

        $this->addFlash(
            'success',
            'Votre annonce a bien été supprimée ! '
        );

        return $this->redirectToRoute('app_notice');
    }
}
