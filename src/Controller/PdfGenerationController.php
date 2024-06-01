<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Filesystem\Filesystem;
use App\Service\PdfGenerationService;
use Symfony\Component\HttpFoundation\Request;


class PdfGenerationController extends AbstractController
{
    public function __construct(PdfGenerationService $pdfService)
    {
    }

    #[Route('/url-to-pdf', name: 'app_url_to_pdf')]
    public function index(Request $request, PdfGenerationService $service): Response
    {
        $url = $request->query->get('url');
        $pdf = $service->fromUrl($url);

        return new Response($pdf, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="output.pdf"'
        ]);
    }
}
