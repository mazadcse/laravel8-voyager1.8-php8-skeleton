<?php

namespace App\Actions;

use TCG\Voyager\Actions\AbstractAction;

class StockExchangeAction extends AbstractAction
{
    public function getTitle()
    {
        return 'Exchange';
    }

    public function getIcon()
    {
        return 'voyager-receipt';
    }

    public function getAttributes()
    {
        return [
            'class' => 'btn btn-sm btn-primary pull-right pr-1',
            'style' => 'margin-right:5px',
        ];
    }

    public function shouldActionDisplayOnDataType()
    {
//        return $this->dataType->slug == 'stocks';
    }

    public function getDefaultRoute()
    {
//        return route('admin.purchase.edit', array("id"=>$this->data->{$this->data->getKeyName()}));
//        return '#'.$this->data->{$this->data->getKeyName()};
//        return 'javascript:alert("22");'.$this->data->{$this->data->getKeyName()};
        return 'javascript:openModal("'.$this->data->{$this->data->getKeyName()}.'");';
    }
}
