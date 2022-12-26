<?php

namespace Modules\Product\Queries;

use Applications\CMS\Sku\Entities\Demand;
use Applications\CMS\Sku\Queries\GetSkuSpecificationValuesForModelQuery;
use Applications\CMS\Sku\Transports\API\ViewModels\SkuDetailViewModel;
use Ecotone\Modelling\Attribute\QueryHandler;
use Ecotone\Modelling\QueryBus;
use Modules\Product\Enums\TenancyApp;

final class NeedToGetSkuDetailQueryHandler
{
    #[QueryHandler]
    public function __invoke(NeedToGetSkuDetailQuery $event, QueryBus $queryBus): SkuDetailViewModel
    {
        $sku = $event->sku;

        $viewModel = new SkuDetailViewModel();

        $viewModel->skuId = $sku->id;
        $viewModel->productId = $sku->product_id;
        $viewModel->SKU = $sku->SKU;
        $viewModel->MPN = $sku->MPN;
        $viewModel->modelName = $sku->model_name;
        $viewModel->colorId = $sku->color_id;
        $viewModel->guaranteeId = $sku->guarantee_id;
        $viewModel->condition = $sku->tinh_trang->name;
        $viewModel->source = $sku->nguon_hang->name;
        $viewModel->price = $sku->price;
        $viewModel->specs = $sku->specs;
        $viewModel->onBiz = $sku->ttkd;
        $viewModel->images = $sku->images;
        $viewModel->videos = $sku->videos;
        $viewModel->youtubeVideo = $sku->youtube_video;
        $viewModel->frontDisplay = $sku->front_display->name;
        $viewModel->frontSites = $sku->tenancies->pluck('site')
            ->map(static fn (TenancyApp $site) => $site->name)->all();
        $viewModel->tags = $sku->tags->pluck('id')->all();
        $viewModel->demands = $sku->demands->map(static fn (Demand $demand) => [
            'demandId' => $demand->id,
            'points' => $demand->pivot->points,
        ])->all();
        $viewModel->specifications = $queryBus->send(new GetSkuSpecificationValuesForModelQuery($sku));

        $articleIds = $sku->article_ids ?? [];
        $articles = [];
        foreach ($articleIds as $site => $articleId) {
            $articles[] = [
                'articleId' => $articleId,
                'frontSite' => $site,
            ];
        }
        $viewModel->articles = $articles;

        return $viewModel;
    }
}
