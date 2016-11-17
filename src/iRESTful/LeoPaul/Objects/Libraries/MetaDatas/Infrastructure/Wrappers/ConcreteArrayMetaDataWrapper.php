<?php
namespace iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Wrappers;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\Arrays\Wrappers\ArrayMetaDataWrapper;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\Arrays\ArrayMetaData;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Objects\Adapters\ObjectAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Arguments\Arrays\Exceptions\ArrayMetaDataException;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Objects\Exceptions\ObjectException;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Transformers\Wrappers\Adapters\TransformerWrapperAdapter;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Domain\Classes\Constructors\Transformers\Exceptions\TransformerException;

final class ConcreteArrayMetaDataWrapper implements ArrayMetaDataWrapper {
    private $transformerWrapperAdapter;
	private $objectAdapter;
	private $arrayMetaData;
	private $callBackOnFail;
	public function __construct(TransformerWrapperAdapter $transformerWrapperAdapter, ObjectAdapter $objectAdapter, ArrayMetaData $arrayMetaData, \Closure $callBackOnFail = null) {
        $this->transformerWrapperAdapter = $transformerWrapperAdapter;
        $this->objectAdapter = $objectAdapter;
		$this->arrayMetaData = $arrayMetaData;
		$this->callBackOnFail = $callBackOnFail;
	}

	public function transform($data) {

		try {

            if ($this->arrayMetaData->hasElementsType()) {
                $input = [];
    			$elementsType = $this->arrayMetaData->getElementsType();
    			foreach($data as $oneKeyname => $oneValue) {
    				$input[$oneKeyname] = [
    					'class' => $elementsType,
    					'callback_on_fail' => $this->callBackOnFail,
    					'data' => $oneValue
    				];

    			}

    			return $this->objectAdapter->fromDataToObjects($input);;
    		}

            if ($this->arrayMetaData->hasTransformers()) {
                $toObjectTransformer = $this->arrayMetaData->getToObjectTransformer();
                $transformerWrapper = $this->transformerWrapperAdapter->fromTransformerToTransformerWrapper($toObjectTransformer);
				return $transformerWrapper->transform($data);
            }
            
            throw new ArrayMetaDataException('The was no criteria in the ArrayMetaData object.');

		} catch (ObjectException $exception) {
			throw new ArrayMetaDataException('There was an exception while converting data to objects.', $exception);
		} catch (TransformerException $exception) {
            throw new ArrayMetaDataException('There was an exception while transforming data.', $exception);
        }
	}

}
