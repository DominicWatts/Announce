<?php

declare(strict_types=1);

namespace Xigen\Announce\Model\Group;

use Magento\Framework\App\Request\DataPersistorInterface;
use Xigen\Announce\Helper\Data;
use Xigen\Announce\Model\ResourceModel\Group\CollectionFactory;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var CollectionFactory
     */
    protected $collection;

    /**
     * @var array
     */
    protected $loadedData;

    /**
     * Constructor
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $model) {
            $form = $this->loadedData[$model->getId()][Data::GROUP_TAB] = $model->getData();
            $form['category'] = explode(',', (string) $form['category']);
        }
        $data = $this->dataPersistor->get('xigen_announce_group');

        if (!empty($data)) {
            $model = $this->collection->getNewEmptyItem();
            $model->setData($data);
            $this->loadedData[$model->getId()][Data::GROUP_TAB] = $model->getData();
            $this->dataPersistor->clear('xigen_announce_group');
        } else {
            if ($items) {
                if ($model->getData('category')) {
                    $group[$model->getId()][Data::GROUP_TAB] = $form;
                    return $group;
                }
            }
        }

        return $this->loadedData;
    }
}
