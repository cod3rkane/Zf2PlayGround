<?php
/**
 * Created by Cod3r Kane.
 * Date: 09/09/2016
 * Time: 13:45
 */

namespace Application\Controller\Api;

use Application\Model\Api\SintegraModel;
use Application\Model\User;
use Zend\EventManager\EventManagerInterface;
use Zend\Http\Client;
use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractRestfulController;

class SintegraController extends AbstractRestfulController
{
    private $model;
    private $container;

    public function __construct(SintegraModel $model, \Interop\Container\ContainerInterface $container)
    {
        $this->model = $model;
        $this->container = $container;
    }

    public function get($id)
    {
        /** @var User $userModel */
        $userModel = $this->container->get(User::class);
        $response = $this->getResponse();

        if ($userModel->user()) {
            // Configurações do Curl, código já é alto explicativo.
            $request = new Request();
            $request->setUri('http://www.sintegra.es.gov.br/resultado.php');
            $request->setMethod('POST');

            $client = new Client();
            $adapter = new \Zend\Http\Client\Adapter\Curl();
            $client->setAdapter($adapter);

            $adapter->setOptions(array(
                'curloptions' => array(
                    CURLOPT_POST => 1,
                    CURLOPT_POSTFIELDS => 'num_cnpj=' . $this->model->mask($id, '##.###.###-####-##') . '&num_ie=&botao=Consultar',
                    CURLOPT_RETURNTRANSFER => 1,
                    CURLOPT_SSL_VERIFYPEER => FALSE,
                    CURLOPT_SSL_VERIFYHOST => FALSE,
                )
            ));

            $curlResponse = $client->dispatch($request);
            $curlContent = $curlResponse->getContent();

            $dataToParse = $curlContent;
            $resultArray = array();
            while (strstr($dataToParse, '<td class="titulo"') != '') {
                // Aqui Pegamos o procuramos a primeira ocorrencia da classe titulo.
                // Retiramos os characters que não são interessantes(HTML, :, etc...).
                $title = utf8_encode(preg_replace("/&#?[a-z0-9]{2,8};/i", "", str_replace(['>', ':'], '',
                    strstr(strstr(strstr($dataToParse, '<td class="titulo"'), '>'), '</td>', true))));
                // com esse titulo salvo, vamos remover ele da nossa string, assim podemos usar essa mesma string para
                // procurar a proxima ocorrencia do titulo com um novo valor.
                $dataToParse = substr($dataToParse, strpos($dataToParse, '<td class="titulo"'), strlen($dataToParse));
                // vamos pegar seu valor agora.
                $value = preg_replace("/&#?[a-z0-9]{2,8};/i", "", str_replace(['>', ':'], '', strstr(strstr(strstr($dataToParse,
                    '<td class="valor"'), '>'), '</td>', true)));
                // também removemos a ocorrência da classe valor, para buscar a proxima ocorrencia na iteração.
                $dataToParse = substr($dataToParse, strpos($dataToParse, '<td class="valor"'), strlen($dataToParse));
                $resultArray[$title] = $value;
            }

            if (count($resultArray) > 0) {
                $json = json_encode($resultArray);
                $this->model->saveIntegra($id, $json);
                $response->setContent($json);
                $response->setStatusCode(200);
            } else {
                $response->setStatusCode(400);
            }

            return $response;
        }

        $response->setContent('Not Allowed');
        $response->setStatusCode(400);
        return $response;
    }

    public function deleteAction()
    {
        /** @var User $userModel */
        $userModel = $this->container->get(User::class);
        $response = $this->getResponse();
        if ($userModel->user()) {
            $id = $this->params()->fromRoute('id');
            if ($this->model->delete($id)) {
                $response->setContent('OK');
                $response->setStatusCode(200);
                return $response;
            }
        }

        $response->setContent('Not Allowed');
        $response->setStatusCode(400);
        return $response;
    }
}