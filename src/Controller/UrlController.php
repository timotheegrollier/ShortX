<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Url;

class UrlController extends AbstractController
{
    /**
     * @Route("/", name="app_url_create")
     */
    public function create(Request $request): Response
    {
        $form =  $this->createFormBuilder()
            ->add('original', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Enter the URL to shorten here !', 'autocomplete' => "off"
                ],
                'constraints' => [
                    new NotBlank(['message' => 'You need to enter an URL']),
                    new Url()
                ]
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dd("traitement");
        }


        return $this->render('url/create.html.twig', ['form' => $form->createView()]);
    }
}
