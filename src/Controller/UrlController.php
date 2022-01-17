<?php

namespace App\Controller;

use App\Entity\Url;
use App\Repository\UrlRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Constraints\Url as UrlConstraint;

class UrlController extends AbstractController
{
    /**
     * @Route("/", name="app_home", methods={"GET","POST"})
     * @Route("/", name="app_url_create", methods={"GET","POST"})
     */
    public function create(Request $request,UrlRepository $urlRepository): Response
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
                    new UrlConstraint()
                ]
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // dd($request->request->all());
         $url=  $urlRepository->findOneBy(['original'=>$form->get('original')->getData()]);

         if ($url){
           return $this->redirectToRoute('app_url_preview',['shortened'=>$url->getShortened()]);
         }

        }


        return $this->render('url/create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/{shortened}/preview",name="app_url_preview", methods="GET")
     */

    public function preview(Url $url): Response
    {
        return $this->render('url/preview.html.twig', compact('url'));
    }


    /**
     * @Route("/{shortened}",name="app_url_show", methods="GET")
     */

    public function show(Url $url):Response
    {
        return $this->redirect($url->getOriginal());
    }

}
