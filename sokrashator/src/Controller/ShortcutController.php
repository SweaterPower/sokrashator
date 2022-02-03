<?php

namespace App\Controller;

use App\Entity\Shortcut;
use App\Form\ShortcutType;
use App\Repository\ShortcutRepository;
use App\Service\ShortcutCodeGenerator;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShortcutController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(Request $request, ShortcutCodeGenerator $codeGenerator, ManagerRegistry $doctrine): Response
    {
        $shortcut = new Shortcut();

        $form = $this->createForm(ShortcutType::class, $shortcut);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $shortcut->setCode($codeGenerator->generateCode());
            $shortcut->setViewCount(0);

            $entityManager = $doctrine->getManager();
            $entityManager->persist($shortcut);
            $entityManager->flush();

            return $this->redirectToRoute('success', [
                'code' => $shortcut->getCode(),
            ]);
        }

        return $this->renderForm('index.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * @Route("/success/{code}", name="success")
     */
    public function success(string $code, ShortcutRepository $repository): Response
    {
        $shortcut = $repository->findOneBy(['code' => $code]);

        if ($shortcut) {
            return $this->render('success.html.twig', [
                'code' => $shortcut->getAlias() ?? $shortcut->getCode(),
            ]);
        }

        return $this->render('error.html.twig');
    }

    /**
     * @Route("/{code}", name="shortcut")
     * @throws NonUniqueResultException
     */
    public function shortcut(string $code, ShortcutRepository $repository, ManagerRegistry $doctrine): Response
    {
        $shortcut = $repository->findOneByCodeOrAlias($code);

        if ($shortcut) {
            $shortcut->increaseViewCount();
            $entityManager = $doctrine->getManager();
            $entityManager->persist($shortcut);
            $entityManager->flush();

            return $this->redirect($shortcut->getLink());
        }

        return $this->render('error.html.twig');
    }
}
