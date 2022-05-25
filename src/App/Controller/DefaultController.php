<?php

namespace App\Controller;

use SharedKernel\Model\Exception\UnexpectedSituationException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use UrlMinimization\Application\Service\GetUrlService;
use UrlMinimization\Application\Service\MinifiedUrlGenerateService;
use UrlMinimization\Application\Service\StatisticService;
use UrlMinimization\Application\Transformer\Transition\TransitionToArrayTransformer;
use UrlMinimization\Domain\Entity\ExpiredDateTime;
use UrlMinimization\Domain\Entity\MinifiedRequest;
use UrlMinimization\Domain\Entity\MinifiedToken;
use UrlMinimization\Domain\Entity\Transition\Transition;
use UrlMinimization\Domain\Entity\Transition\TransitionDateTime;
use UrlMinimization\Domain\Entity\Url;
use UrlMinimization\Domain\Exception\ExpiredDateTimeInvalidValueException;
use UrlMinimization\Domain\Exception\ExpiredDateTimeLessThenCurrentOneException;
use UrlMinimization\Domain\Exception\MinifiedTokenInvalidValueException;
use UrlMinimization\Domain\Exception\MinifiedUrlFailedException;
use UrlMinimization\Domain\Exception\MinimizationSaveFailedException;
use UrlMinimization\Domain\Exception\Transition\TransitionSaveFailedException;
use UrlMinimization\Domain\Exception\UrlExpiredException;
use UrlMinimization\Domain\Exception\UrlInvalidValueException;
use UrlMinimization\Domain\Exception\UrlNotFoundException;

class DefaultController extends AbstractController
{
    private GetUrlService $getUrlService;
    private MinifiedUrlGenerateService $minifiedUrlGenerateService;
    private StatisticService $statisticService;
    private TransitionToArrayTransformer $transitionToArrayTransformer;

    public function __construct(
        GetUrlService $getUrlService,
        MinifiedUrlGenerateService $minifiedUrlGenerateService,
        StatisticService $statisticService,
        TransitionToArrayTransformer $transitionToArrayTransformer
    ) {
        $this->getUrlService = $getUrlService;
        $this->minifiedUrlGenerateService = $minifiedUrlGenerateService;
        $this->statisticService = $statisticService;
        $this->transitionToArrayTransformer = $transitionToArrayTransformer;
    }

    public function index(string $rawMinifiedToken = ''): Response
    {
        if (empty($rawMinifiedToken)) {
            return $this->render('index.html.twig');
        }
        try {
            $minifiedToken = new MinifiedToken($rawMinifiedToken);
            $urlToMinifiedTokenBinding = $this->getUrlService->getByMinifiedToken($minifiedToken);
            $this->statisticService->addTransition(
                new Transition(
                    TransitionDateTime::buildNow(),
                    $minifiedToken,
                ),
            );
            return new Response(
                '<html><body>Redirect to '. $urlToMinifiedTokenBinding->getUrl()->getValue() .'</body></html>'
            );
//            return $this->redirect($urlToMinifiedTokenBinding->getUrl()->getValue());
        } catch (UrlExpiredException|MinifiedTokenInvalidValueException|UrlNotFoundException $exception) {
            return $this->redirectToRoute('not_found');
        } catch (UnexpectedSituationException|TransitionSaveFailedException $exception) {
            return $this->redirectToRoute('index');
        }
    }

    public function minified(Request $request): Response
    {
        try {
            $minifiedToken = $this->minifiedUrlGenerateService
                ->buildByRequest(
                    new MinifiedRequest(
                        new Url($request->request->get('url')),
                        new ExpiredDateTime($request->request->get('date-time'))
                    ),
                )->getMinifiedToken();

            return $this->render(
                'minified.html.twig',
                ['url' => $this->getUrlService->getMinifiedUrlByMinifiedToken($minifiedToken)->getValue()]
            );
        } catch (
            ExpiredDateTimeLessThenCurrentOneException
            |UrlInvalidValueException
            |ExpiredDateTimeInvalidValueException $e
        ) {
            $this->addFlash('notice', $e->getMessage());

            return $this->redirectToRoute('index');
        } catch (
            MinifiedUrlFailedException
            |MinimizationSaveFailedException
            |UnexpectedSituationException $e
        ) {
            $this->addFlash('error', $e->getMessage());

            return $this->redirectToRoute('index');
        }
    }

    public function not_found(): Response
    {
        return new Response(
            '<html><body>not_found</body></html>'
        );
    }

    public function statistic(Request $request): Response
    {
        try {
            $rawMinifiedToken = $request->request->get('token');
            $transitions = !empty($rawMinifiedToken)
                ? $this->statisticService->getTransitionsByMinifiedToken(
                    new MinifiedToken($rawMinifiedToken),
                )
                : null;

            return $this->render(
                'statistic.html.twig',
                [
                    'transitions' => null !== $transitions
                        ? $this->transitionToArrayTransformer->transformCollection($transitions)
                        : [],
                ]
            );
        } catch (MinifiedTokenInvalidValueException $exception) {
            return $this->redirectToRoute('not_found');
        } catch (UnexpectedSituationException $exception) {
            return $this->redirectToRoute('statistic');
        }
    }
}