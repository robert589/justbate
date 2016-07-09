<?php
namespace common\widgets;

use yii\base\Widget;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;

class InfiniteScroll extends Widget
{

    /**
     * @var ArrayDataProvider
     */
    public $dataProvider;

    public $requestUrl;

    public $targetFile;

    public $itemView;

    public $suffixId;

    private $prefixId = 'infinite-scroll-';

    public $navigationText = 'Load more..';

    public function init()
    {
        parent::init();
        $this->registerAssets();
    }

    public function registerAssets(){
        $view = $this->getView();
        InfiniteScrollAsset::register($view);

    }

    public function run()
    {
        $completeView = '';
        $id = $this->prefixId . $this->suffixId;
        $allModels = $this->dataProvider->getModels();
        $pagination = $this->dataProvider->getPagination();
        $completeView .= '<div class="col-xs-12" id="'. $id .'">';
        foreach($allModels as $model) {
            $completeView .= '<div class="item">';
            $completeView .= $this->getView()->render($this->targetFile, ['child_comment' => $model]);
            $completeView .= '</div>';
        }

        $completeView .= $this->render('infinite-scroll', ['navigationText' => $this->navigationText,
                                                            'requestUrl' => $this->requestUrl,
                                                            'id' => $id,
                                                            'perPage' => $pagination->getPageSize(),
                                                            'totalCount' => $this->dataProvider->getTotalCount()]) ;

        $completeView .= '</div>';
        return $completeView;



    }
}