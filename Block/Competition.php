<?php
/**
 * Created by PhpStorm.
 * User: Linh
 * Date: 5/21/2016
 * Time: 1:16 AM
 */
namespace PL\Competition\Block;
class Competition extends \Magento\Framework\View\Element\Template{

    protected $_competitionFactory;

    protected $_competitionHelper;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \PL\Competition\Model\CompetitionFactory $competitionFactory,
        \PL\Competition\Helper\Data $competitionHelper,
        array $data = []
    ) {
        $this->_competitionFactory = $competitionFactory;
        $this->_competitionHelper = $competitionHelper;
        parent::__construct($context, $data);
    }

    protected  function _construct()
    {
        parent::_construct();
        $collection = $this->_competitionFactory->create()->getCollection()
            ->setOrder('date_to', 'DESC');
        $this->setCollection($collection);
    }

    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        /** @var \Magento\Theme\Block\Html\Pager */
        $pager = $this->getLayout()->createBlock(
            'Magento\Theme\Block\Html\Pager',
            'competition.list.pager'
        );
        $pager->setLimit(5)
            ->setShowAmounts(false)
            ->setCollection($this->getCollection());

        $this->setChild('pager', $pager);
        $this->getCollection()->load();

        return $this;
    }

    public function getImageUrl(\PL\Competition\Model\Competition $competition, $name='')
    {
        if($name!=""){
            return $this->_competitionHelper->getBaseUrlMedia($competition->getData($name));
        }

    }
}