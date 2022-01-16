<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UrlController extends AbstractController
{
    /**
     * @Route("/", name="app_url_create")
     */
    public function create(): Response
    {
        $form =  $this->createFormBuilder()
            ->add('original', TextType::class, [
                'label' => false,
                'attr' => ['placeholder' => 'Enter the URL to shorten here !']
            ])
            ->getForm();
        return $this->render('url/create.html.twig', ['form' => $form->createView()]);
    }
}
