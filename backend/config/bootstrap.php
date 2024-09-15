<?php

use common\factories\SerializerFactory;
use common\repositories\TicketRepository;
use common\repositories\TicketRepositoryInterface;
use common\repositories\TokenRepository;
use common\repositories\TokenRepositoryInterface;
use common\repositories\UserRepository;
use common\repositories\UserRepositoryInterface;
use common\services\TicketChangelogService;
use common\services\TicketChangelogServiceInterface;
use common\services\TicketService;
use common\services\TicketServiceInterface;
use common\services\TokenService;
use common\services\TokenServiceInterface;
use common\services\UserService;
use common\services\UserServiceInterface;
use Symfony\Component\PropertyAccess\PropertyAccessor;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Symfony\Component\Serializer\SerializerInterface;

/** Services */
Yii::$container->set(class: UserServiceInterface::class, definition: UserService::class);
Yii::$container->set(class: TokenServiceInterface::class, definition: TokenService::class);
Yii::$container->set(class: TicketServiceInterface::class, definition: TicketService::class);
Yii::$container->set(class: TicketChangelogServiceInterface::class, definition: TicketChangelogService::class);

/** Repositories */
Yii::$container->set(class: TokenRepositoryInterface::class, definition: TokenRepository::class);
Yii::$container->set(class: UserRepositoryInterface::class, definition: UserRepository::class);
Yii::$container->set(class: TicketRepositoryInterface::class, definition: TicketRepository::class);

/** Vendor */
Yii::$container->set(class: SerializerInterface::class, definition: [SerializerFactory::class, 'create']);
Yii::$container->set(class: PropertyAccessorInterface::class, definition: PropertyAccessor::class);
