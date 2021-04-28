<?php
namespace Innovatis\Checkout\Controller\CheckCep;

class Index extends \Magento\Framework\App\Action\Action
{
    protected $_pageFactory;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory
    ) {
        $this->_pageFactory = $pageFactory;
        return parent::__construct($context);
    }

    public function execute()
    {
        if ($this->getRequest()->getParam('cep', false)) {
            $cep = $this->getRequest()->getParam('cep', false);
        } else {
            $cep = $this->getRequest()->getQuery('cep', false);
        }

        $webservice = 'http://cep.republicavirtual.com.br/web_cep.php';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $webservice . '?cep=' . urlencode($cep) . '&formato=javascript');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

        $resultado = curl_exec($ch);
        curl_close($ch);

        echo $resultado;
        exit;
    }
}
