<?php

namespace App\Controller;

use App\Entity\Clientes;
use App\Form\ClientesType;
use App\Repository\ClientesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Elemento;
#[Route('/clientes')]
class ClientesController extends AbstractController
{
    #[Route('/', name: 'app_clientes_index', methods: ['GET'])]
    public function index(ClientesRepository $clientesRepository): Response
    {
        return $this->render('clientes/index.html.twig', [
            'clientes' => $clientesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_clientes_new', methods: ['GET', 'POST'])]
public function new(Request $request, EntityManagerInterface $entityManager): Response
{
    $cliente = new Clientes();
    $cliente->setFecha(new \DateTime()); // Establecer la fecha y hora actual
    $form = $this->createForm(ClientesType::class, $cliente);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager->persist($cliente);
        $entityManager->flush();

        return $this->redirectToRoute('app_clientes_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->renderForm('clientes/new.html.twig', [
        'cliente' => $cliente,
        'form' => $form,
    ]);
}

    #[Route('/{id}', name: 'app_clientes_show', methods: ['GET'])]
    public function show(Clientes $cliente): Response
    {
        return $this->render('clientes/show.html.twig', [
            'cliente' => $cliente,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_clientes_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Clientes $cliente, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ClientesType::class, $cliente, ['is_edit' => true]); // Agregar esta línea
    
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
    
            return $this->redirectToRoute('app_clientes_index', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->renderForm('clientes/edit.html.twig', [
            'cliente' => $cliente,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_clientes_delete', methods: ['POST'])]
    public function delete(Request $request, Clientes $cliente, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cliente->getId(), $request->request->get('_token'))) {
            $cliente->setVisible(false);
            $entityManager->flush();
        }
    
        // Redirige al usuario de vuelta a la lista de clientes
        return $this->redirectToRoute('app_clientes_index');
    }
    #[Route('/exportar-pdf', name: 'app_exportar_clientes_pdf')]
    public function exportarAPdf(): Response
    {
        $clientes = $this->getDoctrine()->getRepository(Clientes::class)->findAll();
        $mpdf = new \Mpdf\Mpdf();
        $html = $this->renderView('clientes/exportar_pdf.html.twig', [
            'clientes' => $clientes,
        ]);
        $mpdf->WriteHTML($html);
        $mpdf->Output('clientes.pdf', 'D');
        return new Response();
    }

   
}
