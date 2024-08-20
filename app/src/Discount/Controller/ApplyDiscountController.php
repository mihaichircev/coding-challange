<?php

namespace App\Discount\Controller;

use App\Discount\DataProvider\OrderDataProvider;
use App\Discount\DataTransformer\OrderDataTransformer;
use App\Discount\Processor\OrderDiscountProcessor;
use App\Discount\Validator\OrderInputValidator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
class ApplyDiscountController
{
    public function __construct(
        private readonly OrderDataProvider $orderDataProvider,
        private readonly OrderInputValidator $orderInputValidator,
        private readonly OrderDataTransformer $orderDataTransformer,
        private readonly OrderDiscountProcessor $orderDiscountProcessor,
    ) {
    }

    #[Route('/discount/apply', name: 'app_discount_apply', methods: 'POST')]
    public function discount(Request $request): Response
    {
        $input = $this->orderDataProvider->provide($request->getContent());
        $this->orderInputValidator->validate($input);

        $output = $this->orderDiscountProcessor->process($input);

        return new JsonResponse($this->orderDataTransformer->transform($output));
    }
}
