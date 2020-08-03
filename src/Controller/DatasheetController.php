<?php

namespace App\Controller;

use A2Global\CRMBundle\Datasheet\Datasheet;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/** @Route("/datasheet/", name="datasheet_") */
class DatasheetController extends AbstractController
{
    /** @Route("examples", name="examples") */
    public function examplesAction()
    {
        $data = $this->getSampleArray();
        $arrayDatasheet = new Datasheet($data);

        return $this->render('datasheet/examples.html.twig', [
            'arrayDatasheet' => $arrayDatasheet,
        ]);
    }

    /** @Route("use-cases", name="use_cases") */
    public function useCasesAction()
    {
        $arrayDatasheet = new Datasheet($this->getUseCasesArray());

        return $this->render('datasheet/examples.html.twig', [
            'arrayDatasheet' => $arrayDatasheet,
        ]);
    }

    protected function getUseCasesArray()
    {
        return [
            ['id' => '1', 'title' => 'Sample'],
            ['id' => '2', 'title' => 'English'],
            ['id' => '3', 'title' => 'Кириллица'],
        ];
    }

    protected function getSampleArray()
    {
        $dir = sprintf('%s/{*,*/*,*/*/*,*/*/*/*,*/*/*/*/*,}', $this->getParameter('kernel.project_dir'));
//        $dir = sprintf('%s/{*,*/*,*/*/*}', $this->getParameter('kernel.project_dir'));
        $data = [];
        $i = 0;

        foreach (glob($dir, GLOB_BRACE) as $file) {
            if (is_dir($file)) {
                continue;
            }
            ++$i;
            $pathinfo = pathinfo($file);

            $data[] = [
                'id' => $i,
                'filename' => $pathinfo['filename'],
                'extension' => $pathinfo['extension'] ?? '',
                'size' => filesize($file),
                'price' => filesize($file),
                'updatedAt' => new Datetime(date(DATE_ATOM, filemtime($file))),
            ];
        }

        return $data;
    }
}
