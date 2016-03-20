<?php

namespace ExpoHub\Http\Controllers\Api;


use ExpoHub\Http\Requests\CreateEventTypeRequest;
use ExpoHub\Http\Requests\DeleteEventTypeRequest;
use ExpoHub\Http\Requests\UpdateEventTypeRequest;
use ExpoHub\Repositories\Contracts\EventTypeRepository;
use ExpoHub\Transformers\EventTypeTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use League\Fractal\Manager;
use League\Fractal\Serializer\JsonApiSerializer;

class EventTypeController extends ApiController
{
	/** @var EventTypeRepository */
	private $eventTypeRepository;

	/**
	 * EventTypeController constructor.
	 *
	 * @param EventTypeRepository $repository
	 * @param Manager $fractal
	 * @param JsonApiSerializer $serializer
	 * @param EventTypeTransformer $transformer
	 */
	public function __construct(EventTypeRepository $repository, Manager $fractal,
								JsonApiSerializer $serializer, EventTypeTransformer $transformer)
	{
		parent::__construct($fractal, $serializer, $transformer);
		$this->eventTypeRepository = $repository;
	}

	/**
	 * @param Request $request
	 * @return JsonResponse
	 */
	public function index(Request $request)
	{
		$this->prepareRepo($this->eventTypeRepository, $request);
		return $this->respondJson($this->eventTypeRepository->all());
	}

	/**
	 * @param Request $request
	 * @param $id
	 * @return JsonResponse
	 */
	public function show(Request $request, $id)
	{
		$this->prepareRepo($this->eventTypeRepository, $request);
		return $this->respondJson($this->eventTypeRepository->find($id));
	}

	/**
	 * @param CreateEventTypeRequest $request
	 * @return JsonResponse
	 */
	public function store(CreateEventTypeRequest $request)
	{
		$parameters = $request->only('name');

		$this->setStatus(Response::HTTP_CREATED);

		return $this->respondJson(
			$this->eventTypeRepository->create($parameters)
		);
	}

	/**
	 * @param UpdateEventTypeRequest $request
	 * @param $id
	 * @return JsonResponse
	 */
	public function update(UpdateEventTypeRequest $request, $id)
	{
		$currentEventType = $this->eventTypeRepository->find($id);
		return $this->respondJson(
			$this->eventTypeRepository->update($id, [
				'name' => $request->has('name') ? $request->get('name') : $currentEventType->name
			])
		);
	}

	/**
	 * @param DeleteEventTypeRequest $request
	 * @param $id
	 * @return JsonResponse
	 */
	public function destroy(DeleteEventTypeRequest $request, $id)
	{
		$this->eventTypeRepository->delete($id);
		return $this->respondNoContent();
	}
}