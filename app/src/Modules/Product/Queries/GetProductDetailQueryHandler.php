<?php

namespace Modules\Product\Queries;

use Ecotone\Modelling\Attribute\QueryHandler;
use Modules\Common\Exceptions\NotFoundEntityException;
use Modules\Common\Utils\ImageUrlHandler;
use Modules\Common\ValueObjects\AbstractValueObject;
use Modules\Product\Entities\Product;
use Modules\Product\Transports\API\ViewModels\ProductDetailViewModel;

final class GetProductDetailQueryHandler extends AbstractValueObject
{
    /**
     * @throws NotFoundEntityException
     */
    #[QueryHandler]
    public function __invoke(GetProductDetailQuery $query): array
    {
        /** @var Product $product */
        $product = Product::query()->with(['tags', 'tenancies'])->find($query->productId);
        
        if (null === $product) {
            throw new NotFoundEntityException('Product');
        }
        
        $viewModel = new ProductDetailViewModel();
        
        $viewModel->productId = $product->id;
        $viewModel->name = $product->name;
        $viewModel->shortDescription = $product->short_description;
        $viewModel->frontDisplay = $product->front_display->name;
        $viewModel->categoryId = $product->category_id;
        $viewModel->brandId = $product->brand_id;
        $viewModel->variantSettings = $product->variant_settings ?? [];
        $viewModel->isPredicted = $product->is_predicted;
        
        $viewModel->images = $product->images ?? [];
        
        $viewModel->images = array_map(static function (string $image) {
            return (new ImageUrlHandler())($image);
        }, $viewModel->images);
        
        $viewModel->videos = $product->videos ?? [];
        $viewModel->youtubeVideo = $product->youtube_video ?? null;
        $viewModel->tags = $product->tags->pluck('id')->all();
        
        return $viewModel->toArray();
    }
}
