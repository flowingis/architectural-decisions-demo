<?php

namespace App\Controller;

use App\Entity\Widget;
use App\Form\WidgetType;
use App\Repository\WidgetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/widget")
 */
class WidgetController extends AbstractController
{
    /**
     * @Route("/", name="widget_index", methods={"GET"})
     */
    public function index(WidgetRepository $widgetRepository): Response
    {
        return $this->render('widget/index.html.twig', [
            'widgets' => $widgetRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="widget_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $widget = new Widget();
        $form = $this->createForm(WidgetType::class, $widget);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($widget);
            $entityManager->flush();

            return $this->redirectToRoute('widget_index');
        }

        return $this->render('widget/new.html.twig', [
            'widget' => $widget,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="widget_show", methods={"GET"})
     */
    public function show(Widget $widget): Response
    {
        return $this->render('widget/show.html.twig', [
            'widget' => $widget,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="widget_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Widget $widget): Response
    {
        $form = $this->createForm(WidgetType::class, $widget);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('widget_index');
        }

        return $this->render('widget/edit.html.twig', [
            'widget' => $widget,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="widget_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Widget $widget): Response
    {
        if ($this->isCsrfTokenValid('delete'.$widget->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($widget);
            $entityManager->flush();
        }

        return $this->redirectToRoute('widget_index');
    }
}
