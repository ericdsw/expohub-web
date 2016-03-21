<?php

namespace ExpoHub\AccessControllers;


use ExpoHub\Repositories\Contracts\MapRepository;
use Tymon\JWTAuth\JWTAuth;

class MapAccessController
{
	/** @var JWTAuth */
	private $jwtAuth;

	/** @var MapRepository */
	private $mapRepository;

	/**
	 * MapAccessController constructor.
	 * @param JWTAuth $jwtAuth
	 * @param MapRepository $mapRepository
	 */
	public function __construct(JWTAuth $jwtAuth, MapRepository $mapRepository)
	{
		$this->jwtAuth = $jwtAuth;
		$this->mapRepository = $mapRepository;
	}

	/**
	 * @param $fairId
	 * @return boolean
	 * @throws \Tymon\JWTAuth\Exceptions\JWTException
	 */
	public function canCreateMapForFair($fairId)
	{
		return $this->jwtAuth->parseToken()->toUser()
			->fairs->contains('id', $fairId);
	}

	/**
	 * @param $mapId
	 * @return boolean
	 * @throws \Tymon\JWTAuth\Exceptions\JWTException
	 */
	public function canUpdateMap($mapId)
	{
		$fairId = $this->mapRepository->find($mapId)->fair_id;
		return $this->jwtAuth->parseToken()->toUser()
			->fairs->lists('id')->contains($fairId);
	}

	/**
	 * @param $mapId
	 * @return boolean
	 * @throws \Tymon\JWTAuth\Exceptions\JWTException
	 */
	public function canDeleteMap($mapId)
	{
		$fairId = $this->mapRepository->find($mapId)->fair_id;
		return $this->jwtAuth->parseToken()->toUser()
			->fairs->lists('id')->contains($fairId);
	}
}