<?php
namespace ExpoHub\AccessControllers;

use ExpoHub\Constants\UserType;
use ExpoHub\Repositories\Contracts\CommentRepository;
use Tymon\JWTAuth\JWTAuth;

class CommentAccessController
{
	/** @var JWTAuth */
	private $jwtAuth;

	/** @var CommentRepository */
	private $commentRepository;

	/**
	 * CommentAccessController constructor
	 *
	 * @param JWTAuth $jwtAuth
	 * @param CommentRepository $commentRepository
	 */
	public function __construct(JWTAuth $jwtAuth, CommentRepository $commentRepository)
	{
		$this->jwtAuth = $jwtAuth;
		$this->commentRepository = $commentRepository;
	}

	/**
	 * Checks if the request can update the specified comment
	 *
	 * @param int $commentId
	 * @return bool
	 */
	public function canUpdateComment($commentId)
	{
		return $this->jwtAuth->parseToken()->toUser()->comments
			->contains('id', $commentId);
	}

	/**
	 * Checks if the request can delete the specified comment
	 *
	 * @param int $commentId
	 * @return bool
	 */
	public function canDeleteComment($commentId)
	{
		$user 			= $this->jwtAuth->parseToken()->toUser();
		$commentFairId 	= $this->commentRepository->find($commentId)->ownerNews->fair->id;

		return (
			$user->comments->lists('id')->contains($commentId) 	||
			$user->user_type == UserType::TYPE_ADMIN			||
			$user->fairs->lists('id')->contains($commentFairId)
		);
	}
}
