<?php

declare(strict_types=1);

/**
 * CORS GmbH.
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 *
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 * @copyright  Copyright (c) CORS GmbH (https://www.cors.gmbh)
 * @license    https://www.cors.gmbh/license     GPLv3
 */

namespace CORS\Bundle\FriendlyCaptchaBundle\Controller;

use CORS\Bundle\FriendlyCaptchaBundle\Form\TestForm;
use Pimcore\Controller\Controller;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class TestController extends Controller
{
    /**
     * @Route("/")
     */
    public function testFormAction(Request $request, FormFactoryInterface $formFactory)
    {
        $form = $formFactory->createNamed('our_form', TestForm::class, ['text' => 'blub']);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                die("valid");
            }
        }

        return $this->render('form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
