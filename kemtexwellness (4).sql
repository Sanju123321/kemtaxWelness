-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 12, 2026 at 07:30 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kemtexwellness`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `product_id`, `quantity`, `created_at`, `updated_at`) VALUES
(1, 9, 1, 4, '2026-03-29 09:32:41', '2026-03-29 10:17:31'),
(2, 9, 2, 1, '2026-03-29 09:32:52', '2026-03-29 09:32:52');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `failed_jobs`
--

INSERT INTO `failed_jobs` (`id`, `uuid`, `connection`, `queue`, `payload`, `exception`, `failed_at`) VALUES
(1, 'd9fd860a-e94b-448f-8ac6-75e03df40661', 'database', 'default', '{\"uuid\":\"d9fd860a-e94b-448f-8ac6-75e03df40661\",\"displayName\":\"App\\\\Jobs\\\\DistributeIncomeJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\DistributeIncomeJob\",\"command\":\"O:28:\\\"App\\\\Jobs\\\\DistributeIncomeJob\\\":1:{s:6:\\\"userId\\\";i:11;}\",\"batchId\":null},\"createdAt\":1775498717,\"delay\":null}', 'ReflectionException: Class \"App\\Services\\CommissionService\" does not exist in D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php:1122\nStack trace:\n#0 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(1122): ReflectionClass->__construct(\'App\\\\Services\\\\Co...\')\n#1 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(933): Illuminate\\Container\\Container->build(\'App\\\\Services\\\\Co...\')\n#2 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Application.php(1078): Illuminate\\Container\\Container->resolve(\'App\\\\Services\\\\Co...\', Array, true)\n#3 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(864): Illuminate\\Foundation\\Application->resolve(\'App\\\\Services\\\\Co...\', Array)\n#4 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Application.php(1058): Illuminate\\Container\\Container->make(\'App\\\\Services\\\\Co...\', Array)\n#5 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\helpers.php(138): Illuminate\\Foundation\\Application->make(\'App\\\\Services\\\\Co...\', Array)\n#6 D:\\kemtaxWelness\\app\\Jobs\\DistributeIncomeJob.php(26): app(\'App\\\\Services\\\\Co...\')\n#7 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): App\\Jobs\\DistributeIncomeJob->handle()\n#8 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#9 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#10 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#11 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(799): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#12 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(129): Illuminate\\Container\\Container->call(Array)\n#13 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(180): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(App\\Jobs\\DistributeIncomeJob))\n#14 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(137): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\DistributeIncomeJob))\n#15 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(133): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#16 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(136): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(App\\Jobs\\DistributeIncomeJob), false)\n#17 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(180): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}(Object(App\\Jobs\\DistributeIncomeJob))\n#18 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(137): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\DistributeIncomeJob))\n#19 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(129): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#20 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(70): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(App\\Jobs\\DistributeIncomeJob))\n#21 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(102): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Array)\n#22 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(485): Illuminate\\Queue\\Jobs\\Job->fire()\n#23 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(435): Illuminate\\Queue\\Worker->process(\'database\', Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Queue\\WorkerOptions))\n#24 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(201): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), \'database\', Object(Illuminate\\Queue\\WorkerOptions))\n#25 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(148): Illuminate\\Queue\\Worker->daemon(\'database\', \'default\', Object(Illuminate\\Queue\\WorkerOptions))\n#26 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(131): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'database\', \'default\')\n#27 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#28 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#29 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#30 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#31 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(799): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#32 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(211): Illuminate\\Container\\Container->call(Array)\n#33 D:\\kemtaxWelness\\vendor\\symfony\\console\\Command\\Command.php(341): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#34 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(180): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#35 D:\\kemtaxWelness\\vendor\\symfony\\console\\Application.php(1117): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#36 D:\\kemtaxWelness\\vendor\\symfony\\console\\Application.php(356): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#37 D:\\kemtaxWelness\\vendor\\symfony\\console\\Application.php(195): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#38 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(198): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#39 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Application.php(1235): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#40 D:\\kemtaxWelness\\artisan(16): Illuminate\\Foundation\\Application->handleCommand(Object(Symfony\\Component\\Console\\Input\\ArgvInput))\n#41 {main}\n\nNext Illuminate\\Contracts\\Container\\BindingResolutionException: Target class [App\\Services\\CommissionService] does not exist. in D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php:1124\nStack trace:\n#0 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(933): Illuminate\\Container\\Container->build(\'App\\\\Services\\\\Co...\')\n#1 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Application.php(1078): Illuminate\\Container\\Container->resolve(\'App\\\\Services\\\\Co...\', Array, true)\n#2 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(864): Illuminate\\Foundation\\Application->resolve(\'App\\\\Services\\\\Co...\', Array)\n#3 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Application.php(1058): Illuminate\\Container\\Container->make(\'App\\\\Services\\\\Co...\', Array)\n#4 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\helpers.php(138): Illuminate\\Foundation\\Application->make(\'App\\\\Services\\\\Co...\', Array)\n#5 D:\\kemtaxWelness\\app\\Jobs\\DistributeIncomeJob.php(26): app(\'App\\\\Services\\\\Co...\')\n#6 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): App\\Jobs\\DistributeIncomeJob->handle()\n#7 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#8 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#9 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#10 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(799): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#11 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(129): Illuminate\\Container\\Container->call(Array)\n#12 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(180): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(App\\Jobs\\DistributeIncomeJob))\n#13 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(137): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\DistributeIncomeJob))\n#14 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(133): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#15 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(136): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(App\\Jobs\\DistributeIncomeJob), false)\n#16 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(180): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}(Object(App\\Jobs\\DistributeIncomeJob))\n#17 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(137): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\DistributeIncomeJob))\n#18 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(129): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#19 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(70): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(App\\Jobs\\DistributeIncomeJob))\n#20 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(102): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Array)\n#21 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(485): Illuminate\\Queue\\Jobs\\Job->fire()\n#22 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(435): Illuminate\\Queue\\Worker->process(\'database\', Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Queue\\WorkerOptions))\n#23 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(201): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), \'database\', Object(Illuminate\\Queue\\WorkerOptions))\n#24 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(148): Illuminate\\Queue\\Worker->daemon(\'database\', \'default\', Object(Illuminate\\Queue\\WorkerOptions))\n#25 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(131): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'database\', \'default\')\n#26 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#27 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#28 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#29 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#30 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(799): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#31 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(211): Illuminate\\Container\\Container->call(Array)\n#32 D:\\kemtaxWelness\\vendor\\symfony\\console\\Command\\Command.php(341): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#33 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(180): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#34 D:\\kemtaxWelness\\vendor\\symfony\\console\\Application.php(1117): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#35 D:\\kemtaxWelness\\vendor\\symfony\\console\\Application.php(356): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#36 D:\\kemtaxWelness\\vendor\\symfony\\console\\Application.php(195): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#37 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(198): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#38 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Application.php(1235): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#39 D:\\kemtaxWelness\\artisan(16): Illuminate\\Foundation\\Application->handleCommand(Object(Symfony\\Component\\Console\\Input\\ArgvInput))\n#40 {main}', '2026-04-06 12:35:18'),
(2, 'bb775528-0a9a-46c8-a57f-8b95264bff3a', 'database', 'default', '{\"uuid\":\"bb775528-0a9a-46c8-a57f-8b95264bff3a\",\"displayName\":\"App\\\\Jobs\\\\DistributeIncomeJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\DistributeIncomeJob\",\"command\":\"O:28:\\\"App\\\\Jobs\\\\DistributeIncomeJob\\\":1:{s:6:\\\"userId\\\";i:11;}\",\"batchId\":null},\"createdAt\":1775577341,\"delay\":null}', 'ReflectionException: Class \"App\\Services\\CommissionService\" does not exist in D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php:1122\nStack trace:\n#0 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(1122): ReflectionClass->__construct(\'App\\\\Services\\\\Co...\')\n#1 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(933): Illuminate\\Container\\Container->build(\'App\\\\Services\\\\Co...\')\n#2 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Application.php(1078): Illuminate\\Container\\Container->resolve(\'App\\\\Services\\\\Co...\', Array, true)\n#3 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(864): Illuminate\\Foundation\\Application->resolve(\'App\\\\Services\\\\Co...\', Array)\n#4 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Application.php(1058): Illuminate\\Container\\Container->make(\'App\\\\Services\\\\Co...\', Array)\n#5 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\helpers.php(138): Illuminate\\Foundation\\Application->make(\'App\\\\Services\\\\Co...\', Array)\n#6 D:\\kemtaxWelness\\app\\Jobs\\DistributeIncomeJob.php(29): app(\'App\\\\Services\\\\Co...\')\n#7 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): App\\Jobs\\DistributeIncomeJob->handle()\n#8 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#9 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#10 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#11 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(799): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#12 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(129): Illuminate\\Container\\Container->call(Array)\n#13 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(180): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(App\\Jobs\\DistributeIncomeJob))\n#14 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(137): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\DistributeIncomeJob))\n#15 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(133): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#16 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(136): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(App\\Jobs\\DistributeIncomeJob), false)\n#17 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(180): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}(Object(App\\Jobs\\DistributeIncomeJob))\n#18 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(137): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\DistributeIncomeJob))\n#19 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(129): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#20 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(70): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(App\\Jobs\\DistributeIncomeJob))\n#21 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(102): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Array)\n#22 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(485): Illuminate\\Queue\\Jobs\\Job->fire()\n#23 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(435): Illuminate\\Queue\\Worker->process(\'database\', Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Queue\\WorkerOptions))\n#24 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(201): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), \'database\', Object(Illuminate\\Queue\\WorkerOptions))\n#25 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(148): Illuminate\\Queue\\Worker->daemon(\'database\', \'default\', Object(Illuminate\\Queue\\WorkerOptions))\n#26 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(131): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'database\', \'default\')\n#27 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#28 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#29 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#30 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#31 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(799): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#32 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(211): Illuminate\\Container\\Container->call(Array)\n#33 D:\\kemtaxWelness\\vendor\\symfony\\console\\Command\\Command.php(341): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#34 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(180): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#35 D:\\kemtaxWelness\\vendor\\symfony\\console\\Application.php(1117): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#36 D:\\kemtaxWelness\\vendor\\symfony\\console\\Application.php(356): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#37 D:\\kemtaxWelness\\vendor\\symfony\\console\\Application.php(195): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#38 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(198): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#39 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Application.php(1235): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#40 D:\\kemtaxWelness\\artisan(16): Illuminate\\Foundation\\Application->handleCommand(Object(Symfony\\Component\\Console\\Input\\ArgvInput))\n#41 {main}\n\nNext Illuminate\\Contracts\\Container\\BindingResolutionException: Target class [App\\Services\\CommissionService] does not exist. in D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php:1124\nStack trace:\n#0 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(933): Illuminate\\Container\\Container->build(\'App\\\\Services\\\\Co...\')\n#1 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Application.php(1078): Illuminate\\Container\\Container->resolve(\'App\\\\Services\\\\Co...\', Array, true)\n#2 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(864): Illuminate\\Foundation\\Application->resolve(\'App\\\\Services\\\\Co...\', Array)\n#3 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Application.php(1058): Illuminate\\Container\\Container->make(\'App\\\\Services\\\\Co...\', Array)\n#4 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\helpers.php(138): Illuminate\\Foundation\\Application->make(\'App\\\\Services\\\\Co...\', Array)\n#5 D:\\kemtaxWelness\\app\\Jobs\\DistributeIncomeJob.php(29): app(\'App\\\\Services\\\\Co...\')\n#6 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): App\\Jobs\\DistributeIncomeJob->handle()\n#7 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#8 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#9 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#10 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(799): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#11 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(129): Illuminate\\Container\\Container->call(Array)\n#12 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(180): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(App\\Jobs\\DistributeIncomeJob))\n#13 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(137): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\DistributeIncomeJob))\n#14 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(133): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#15 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(136): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(App\\Jobs\\DistributeIncomeJob), false)\n#16 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(180): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}(Object(App\\Jobs\\DistributeIncomeJob))\n#17 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(137): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\DistributeIncomeJob))\n#18 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(129): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#19 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(70): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(App\\Jobs\\DistributeIncomeJob))\n#20 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(102): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Array)\n#21 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(485): Illuminate\\Queue\\Jobs\\Job->fire()\n#22 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(435): Illuminate\\Queue\\Worker->process(\'database\', Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Queue\\WorkerOptions))\n#23 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(201): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), \'database\', Object(Illuminate\\Queue\\WorkerOptions))\n#24 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(148): Illuminate\\Queue\\Worker->daemon(\'database\', \'default\', Object(Illuminate\\Queue\\WorkerOptions))\n#25 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(131): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'database\', \'default\')\n#26 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#27 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#28 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#29 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#30 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(799): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#31 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(211): Illuminate\\Container\\Container->call(Array)\n#32 D:\\kemtaxWelness\\vendor\\symfony\\console\\Command\\Command.php(341): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#33 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(180): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#34 D:\\kemtaxWelness\\vendor\\symfony\\console\\Application.php(1117): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#35 D:\\kemtaxWelness\\vendor\\symfony\\console\\Application.php(356): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#36 D:\\kemtaxWelness\\vendor\\symfony\\console\\Application.php(195): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#37 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(198): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#38 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Application.php(1235): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#39 D:\\kemtaxWelness\\artisan(16): Illuminate\\Foundation\\Application->handleCommand(Object(Symfony\\Component\\Console\\Input\\ArgvInput))\n#40 {main}', '2026-04-07 10:25:42'),
(3, '8693ed76-b389-4563-9285-c664e7723842', 'database', 'default', '{\"uuid\":\"8693ed76-b389-4563-9285-c664e7723842\",\"displayName\":\"App\\\\Jobs\\\\DistributeIncomeJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\DistributeIncomeJob\",\"command\":\"O:28:\\\"App\\\\Jobs\\\\DistributeIncomeJob\\\":1:{s:6:\\\"userId\\\";i:11;}\",\"batchId\":null},\"createdAt\":1775577520,\"delay\":null}', 'ReflectionException: Class \"App\\Services\\CommissionService\" does not exist in D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php:1122\nStack trace:\n#0 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(1122): ReflectionClass->__construct(\'App\\\\Services\\\\Co...\')\n#1 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(933): Illuminate\\Container\\Container->build(\'App\\\\Services\\\\Co...\')\n#2 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Application.php(1078): Illuminate\\Container\\Container->resolve(\'App\\\\Services\\\\Co...\', Array, true)\n#3 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(864): Illuminate\\Foundation\\Application->resolve(\'App\\\\Services\\\\Co...\', Array)\n#4 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Application.php(1058): Illuminate\\Container\\Container->make(\'App\\\\Services\\\\Co...\', Array)\n#5 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\helpers.php(138): Illuminate\\Foundation\\Application->make(\'App\\\\Services\\\\Co...\', Array)\n#6 D:\\kemtaxWelness\\app\\Jobs\\DistributeIncomeJob.php(29): app(\'App\\\\Services\\\\Co...\')\n#7 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): App\\Jobs\\DistributeIncomeJob->handle()\n#8 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#9 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#10 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#11 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(799): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#12 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(129): Illuminate\\Container\\Container->call(Array)\n#13 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(180): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(App\\Jobs\\DistributeIncomeJob))\n#14 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(137): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\DistributeIncomeJob))\n#15 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(133): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#16 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(136): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(App\\Jobs\\DistributeIncomeJob), false)\n#17 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(180): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}(Object(App\\Jobs\\DistributeIncomeJob))\n#18 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(137): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\DistributeIncomeJob))\n#19 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(129): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#20 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(70): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(App\\Jobs\\DistributeIncomeJob))\n#21 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(102): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Array)\n#22 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(485): Illuminate\\Queue\\Jobs\\Job->fire()\n#23 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(435): Illuminate\\Queue\\Worker->process(\'database\', Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Queue\\WorkerOptions))\n#24 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(201): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), \'database\', Object(Illuminate\\Queue\\WorkerOptions))\n#25 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(148): Illuminate\\Queue\\Worker->daemon(\'database\', \'default\', Object(Illuminate\\Queue\\WorkerOptions))\n#26 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(131): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'database\', \'default\')\n#27 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#28 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#29 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#30 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#31 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(799): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#32 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(211): Illuminate\\Container\\Container->call(Array)\n#33 D:\\kemtaxWelness\\vendor\\symfony\\console\\Command\\Command.php(341): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#34 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(180): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#35 D:\\kemtaxWelness\\vendor\\symfony\\console\\Application.php(1117): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#36 D:\\kemtaxWelness\\vendor\\symfony\\console\\Application.php(356): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#37 D:\\kemtaxWelness\\vendor\\symfony\\console\\Application.php(195): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#38 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(198): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#39 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Application.php(1235): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#40 D:\\kemtaxWelness\\artisan(16): Illuminate\\Foundation\\Application->handleCommand(Object(Symfony\\Component\\Console\\Input\\ArgvInput))\n#41 {main}\n\nNext Illuminate\\Contracts\\Container\\BindingResolutionException: Target class [App\\Services\\CommissionService] does not exist. in D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php:1124\nStack trace:\n#0 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(933): Illuminate\\Container\\Container->build(\'App\\\\Services\\\\Co...\')\n#1 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Application.php(1078): Illuminate\\Container\\Container->resolve(\'App\\\\Services\\\\Co...\', Array, true)\n#2 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(864): Illuminate\\Foundation\\Application->resolve(\'App\\\\Services\\\\Co...\', Array)\n#3 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Application.php(1058): Illuminate\\Container\\Container->make(\'App\\\\Services\\\\Co...\', Array)\n#4 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\helpers.php(138): Illuminate\\Foundation\\Application->make(\'App\\\\Services\\\\Co...\', Array)\n#5 D:\\kemtaxWelness\\app\\Jobs\\DistributeIncomeJob.php(29): app(\'App\\\\Services\\\\Co...\')\n#6 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): App\\Jobs\\DistributeIncomeJob->handle()\n#7 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#8 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#9 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#10 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(799): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#11 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(129): Illuminate\\Container\\Container->call(Array)\n#12 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(180): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(App\\Jobs\\DistributeIncomeJob))\n#13 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(137): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\DistributeIncomeJob))\n#14 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(133): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#15 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(136): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(App\\Jobs\\DistributeIncomeJob), false)\n#16 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(180): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}(Object(App\\Jobs\\DistributeIncomeJob))\n#17 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(137): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\DistributeIncomeJob))\n#18 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(129): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#19 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(70): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(App\\Jobs\\DistributeIncomeJob))\n#20 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(102): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Array)\n#21 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(485): Illuminate\\Queue\\Jobs\\Job->fire()\n#22 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(435): Illuminate\\Queue\\Worker->process(\'database\', Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Queue\\WorkerOptions))\n#23 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(201): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), \'database\', Object(Illuminate\\Queue\\WorkerOptions))\n#24 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(148): Illuminate\\Queue\\Worker->daemon(\'database\', \'default\', Object(Illuminate\\Queue\\WorkerOptions))\n#25 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(131): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'database\', \'default\')\n#26 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#27 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#28 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#29 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#30 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(799): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#31 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(211): Illuminate\\Container\\Container->call(Array)\n#32 D:\\kemtaxWelness\\vendor\\symfony\\console\\Command\\Command.php(341): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#33 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(180): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#34 D:\\kemtaxWelness\\vendor\\symfony\\console\\Application.php(1117): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#35 D:\\kemtaxWelness\\vendor\\symfony\\console\\Application.php(356): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#36 D:\\kemtaxWelness\\vendor\\symfony\\console\\Application.php(195): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#37 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(198): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#38 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Application.php(1235): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#39 D:\\kemtaxWelness\\artisan(16): Illuminate\\Foundation\\Application->handleCommand(Object(Symfony\\Component\\Console\\Input\\ArgvInput))\n#40 {main}', '2026-04-07 10:28:41');
INSERT INTO `failed_jobs` (`id`, `uuid`, `connection`, `queue`, `payload`, `exception`, `failed_at`) VALUES
(4, '19caefaf-0118-4051-b92a-562cd9f5ea72', 'database', 'default', '{\"uuid\":\"19caefaf-0118-4051-b92a-562cd9f5ea72\",\"displayName\":\"App\\\\Jobs\\\\DistributeIncomeJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\DistributeIncomeJob\",\"command\":\"O:28:\\\"App\\\\Jobs\\\\DistributeIncomeJob\\\":1:{s:6:\\\"userId\\\";i:15;}\",\"batchId\":null},\"createdAt\":1775579578,\"delay\":null}', 'Error: Call to undefined method App\\Services\\CommissionService::getPercent() in D:\\kemtaxWelness\\app\\Services\\CommissionService.php:22\nStack trace:\n#0 D:\\kemtaxWelness\\app\\Jobs\\DistributeIncomeJob.php(30): App\\Services\\CommissionService->distributeIncome(15)\n#1 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): App\\Jobs\\DistributeIncomeJob->handle()\n#2 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#3 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#4 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#5 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(799): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#6 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(129): Illuminate\\Container\\Container->call(Array)\n#7 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(180): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(App\\Jobs\\DistributeIncomeJob))\n#8 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(137): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\DistributeIncomeJob))\n#9 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(133): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#10 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(136): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(App\\Jobs\\DistributeIncomeJob), false)\n#11 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(180): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}(Object(App\\Jobs\\DistributeIncomeJob))\n#12 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(137): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\DistributeIncomeJob))\n#13 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(129): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#14 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(70): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(App\\Jobs\\DistributeIncomeJob))\n#15 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(102): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Array)\n#16 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(485): Illuminate\\Queue\\Jobs\\Job->fire()\n#17 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(435): Illuminate\\Queue\\Worker->process(\'database\', Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Queue\\WorkerOptions))\n#18 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(201): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), \'database\', Object(Illuminate\\Queue\\WorkerOptions))\n#19 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(148): Illuminate\\Queue\\Worker->daemon(\'database\', \'default\', Object(Illuminate\\Queue\\WorkerOptions))\n#20 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(131): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'database\', \'default\')\n#21 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#22 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#23 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#24 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#25 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(799): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#26 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(211): Illuminate\\Container\\Container->call(Array)\n#27 D:\\kemtaxWelness\\vendor\\symfony\\console\\Command\\Command.php(341): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#28 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(180): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#29 D:\\kemtaxWelness\\vendor\\symfony\\console\\Application.php(1117): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#30 D:\\kemtaxWelness\\vendor\\symfony\\console\\Application.php(356): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#31 D:\\kemtaxWelness\\vendor\\symfony\\console\\Application.php(195): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#32 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(198): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#33 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Application.php(1235): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#34 D:\\kemtaxWelness\\artisan(16): Illuminate\\Foundation\\Application->handleCommand(Object(Symfony\\Component\\Console\\Input\\ArgvInput))\n#35 {main}', '2026-04-07 11:02:59'),
(5, '56570568-295c-4dd1-9b2c-e5934f17bf3e', 'database', 'default', '{\"uuid\":\"56570568-295c-4dd1-9b2c-e5934f17bf3e\",\"displayName\":\"App\\\\Jobs\\\\DistributeIncomeJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\DistributeIncomeJob\",\"command\":\"O:28:\\\"App\\\\Jobs\\\\DistributeIncomeJob\\\":1:{s:6:\\\"userId\\\";i:15;}\",\"batchId\":null},\"createdAt\":1775579943,\"delay\":null}', 'Error: Call to undefined method App\\Services\\CommissionService::getPercent() in D:\\kemtaxWelness\\app\\Services\\CommissionService.php:22\nStack trace:\n#0 D:\\kemtaxWelness\\app\\Jobs\\DistributeIncomeJob.php(30): App\\Services\\CommissionService->distributeIncome(15)\n#1 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): App\\Jobs\\DistributeIncomeJob->handle()\n#2 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#3 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#4 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#5 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(799): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#6 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(129): Illuminate\\Container\\Container->call(Array)\n#7 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(180): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(App\\Jobs\\DistributeIncomeJob))\n#8 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(137): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\DistributeIncomeJob))\n#9 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(133): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#10 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(136): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(App\\Jobs\\DistributeIncomeJob), false)\n#11 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(180): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}(Object(App\\Jobs\\DistributeIncomeJob))\n#12 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(137): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\DistributeIncomeJob))\n#13 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(129): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#14 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(70): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(App\\Jobs\\DistributeIncomeJob))\n#15 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(102): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Array)\n#16 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(485): Illuminate\\Queue\\Jobs\\Job->fire()\n#17 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(435): Illuminate\\Queue\\Worker->process(\'database\', Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Queue\\WorkerOptions))\n#18 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(201): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), \'database\', Object(Illuminate\\Queue\\WorkerOptions))\n#19 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(148): Illuminate\\Queue\\Worker->daemon(\'database\', \'default\', Object(Illuminate\\Queue\\WorkerOptions))\n#20 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(131): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'database\', \'default\')\n#21 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#22 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(43): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#23 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(96): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#24 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(35): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#25 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(799): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#26 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(211): Illuminate\\Container\\Container->call(Array)\n#27 D:\\kemtaxWelness\\vendor\\symfony\\console\\Command\\Command.php(341): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#28 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(180): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#29 D:\\kemtaxWelness\\vendor\\symfony\\console\\Application.php(1117): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#30 D:\\kemtaxWelness\\vendor\\symfony\\console\\Application.php(356): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#31 D:\\kemtaxWelness\\vendor\\symfony\\console\\Application.php(195): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#32 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(198): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#33 D:\\kemtaxWelness\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Application.php(1235): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#34 D:\\kemtaxWelness\\artisan(16): Illuminate\\Foundation\\Application->handleCommand(Object(Symfony\\Component\\Console\\Input\\ArgvInput))\n#35 {main}', '2026-04-07 11:09:05');

-- --------------------------------------------------------

--
-- Table structure for table `incomes`
--

CREATE TABLE `incomes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `from_user_id` bigint(20) UNSIGNED NOT NULL,
  `level` int(11) NOT NULL,
  `amount` double NOT NULL,
  `type` enum('direct','level','royalty') NOT NULL DEFAULT 'level',
  `status` enum('pending','credited','lost') NOT NULL DEFAULT 'pending',
  `remark` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `incomes`
--

INSERT INTO `incomes` (`id`, `user_id`, `from_user_id`, `level`, `amount`, `type`, `status`, `remark`, `created_at`, `updated_at`) VALUES
(1, 11, 15, 1, 150, 'direct', 'pending', NULL, '2026-04-07 11:11:03', NULL),
(3, 15, 17, 1, 150, 'direct', 'pending', NULL, '2026-04-07 12:10:29', NULL),
(4, 11, 17, 2, 100, 'level', 'pending', NULL, '2026-04-07 12:10:29', NULL),
(5, 17, 18, 1, 150, 'direct', 'pending', NULL, '2026-04-07 12:19:22', NULL),
(6, 15, 18, 2, 100, 'level', 'pending', NULL, '2026-04-07 12:19:22', NULL),
(7, 11, 18, 3, 50, 'level', 'pending', NULL, '2026-04-07 12:19:22', NULL),
(8, 18, 19, 1, 150, 'direct', 'pending', NULL, '2026-04-07 12:24:48', NULL),
(9, 17, 19, 2, 100, 'level', 'pending', NULL, '2026-04-07 12:24:48', NULL),
(10, 15, 19, 3, 50, 'level', 'pending', NULL, '2026-04-07 12:24:48', NULL),
(11, 11, 19, 4, 50, 'level', 'pending', NULL, '2026-04-07 12:24:48', NULL),
(12, 19, 20, 1, 150, 'direct', 'pending', NULL, '2026-04-07 12:28:15', NULL),
(13, 18, 20, 2, 100, 'level', 'pending', NULL, '2026-04-07 12:28:15', NULL),
(14, 17, 20, 3, 50, 'level', 'pending', NULL, '2026-04-07 12:28:15', NULL),
(15, 15, 20, 4, 50, 'level', 'pending', NULL, '2026-04-07 12:28:15', NULL),
(16, 11, 20, 5, 20, 'level', 'pending', NULL, '2026-04-07 12:28:15', NULL),
(17, 25, 26, 1, 150, 'direct', 'pending', NULL, '2026-04-09 08:44:38', NULL),
(18, 26, 27, 1, 150, 'direct', 'pending', NULL, '2026-04-09 08:57:28', NULL),
(19, 25, 27, 2, 100, 'level', 'pending', NULL, '2026-04-09 08:57:28', NULL),
(20, 27, 28, 1, 150, 'direct', 'pending', NULL, '2026-04-09 09:05:02', NULL),
(21, 26, 28, 2, 100, 'level', 'pending', NULL, '2026-04-09 09:05:02', NULL),
(22, 25, 28, 3, 50, 'level', 'pending', NULL, '2026-04-09 09:05:02', NULL),
(23, 28, 29, 1, 150, 'direct', 'pending', NULL, '2026-04-09 09:17:41', NULL),
(24, 27, 29, 2, 100, 'level', 'pending', NULL, '2026-04-09 09:17:41', NULL),
(25, 26, 29, 3, 50, 'level', 'pending', NULL, '2026-04-09 09:17:41', NULL),
(26, 25, 29, 4, 50, 'level', 'pending', NULL, '2026-04-09 09:17:41', NULL),
(27, 29, 30, 1, 150, 'direct', 'pending', NULL, '2026-04-09 09:22:20', NULL),
(28, 28, 30, 2, 100, 'level', 'pending', NULL, '2026-04-09 09:22:20', NULL),
(29, 27, 30, 3, 50, 'level', 'pending', NULL, '2026-04-09 09:22:20', NULL),
(30, 26, 30, 4, 50, 'level', 'pending', NULL, '2026-04-09 09:22:20', NULL),
(31, 25, 30, 5, 20, 'level', 'pending', NULL, '2026-04-09 09:22:20', NULL),
(32, 30, 31, 1, 150, 'direct', 'pending', NULL, '2026-04-09 12:24:41', NULL),
(33, 29, 31, 2, 100, 'level', 'pending', NULL, '2026-04-09 12:24:41', NULL),
(34, 28, 31, 3, 50, 'level', 'pending', NULL, '2026-04-09 12:24:41', NULL),
(35, 27, 31, 4, 50, 'level', 'pending', NULL, '2026-04-09 12:24:41', NULL),
(36, 26, 31, 5, 20, 'level', 'pending', NULL, '2026-04-09 12:24:41', NULL),
(37, 25, 31, 6, 20, 'level', 'pending', NULL, '2026-04-09 12:24:41', NULL),
(38, 31, 32, 1, 150, 'direct', 'pending', NULL, '2026-04-09 12:30:54', NULL),
(39, 30, 32, 2, 100, 'level', 'pending', NULL, '2026-04-09 12:30:54', NULL),
(40, 29, 32, 3, 50, 'level', 'pending', NULL, '2026-04-09 12:30:54', NULL),
(41, 28, 32, 4, 50, 'level', 'pending', NULL, '2026-04-09 12:30:54', NULL),
(42, 27, 32, 5, 20, 'level', 'pending', NULL, '2026-04-09 12:30:54', NULL),
(43, 26, 32, 6, 20, 'level', 'pending', NULL, '2026-04-09 12:30:54', NULL),
(44, 25, 32, 7, 20, 'level', 'pending', NULL, '2026-04-09 12:30:54', NULL),
(45, 28, 34, 1, 150, 'direct', 'pending', NULL, '2026-04-10 12:33:40', NULL),
(46, 27, 34, 2, 100, 'level', 'pending', NULL, '2026-04-10 12:33:40', NULL),
(47, 26, 34, 3, 50, 'level', 'pending', NULL, '2026-04-10 12:33:40', NULL),
(48, 25, 34, 4, 50, 'level', 'pending', NULL, '2026-04-10 12:33:40', NULL),
(49, 25, 35, 1, 150, 'direct', 'pending', NULL, '2026-04-10 14:17:10', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
(16, 'default', '{\"uuid\":\"001dd431-57db-4b36-93ee-570ad5e6e7d0\",\"displayName\":\"App\\\\Jobs\\\\DistributeIncomeJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\DistributeIncomeJob\",\"command\":\"O:28:\\\"App\\\\Jobs\\\\DistributeIncomeJob\\\":1:{s:6:\\\"userId\\\";i:36;}\",\"batchId\":null},\"createdAt\":1775934349,\"delay\":null}', 0, NULL, 1775934349, 1775934349);

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_03_01_180051_add_reference_fields_to_users_table', 2),
(5, '2025_01_01_000010_create_products_table', 3),
(6, '2025_01_01_000011_create_carts_table', 3),
(7, '2025_01_01_000012_create_wishlists_table', 3),
(8, '2025_01_01_000013_create_recently_viewed_table', 3),
(9, '2026_04_04_172857_create_payments_table', 4),
(10, '2026_04_06_162134_create_plans_table', 5),
(11, '2026_04_06_164718_create_user_plans_table', 6),
(12, '2026_04_06_173211_create_user_tree_table', 7),
(14, '2026_04_06_173346_create_incomes_table', 8),
(15, '2026_04_10_190029_add_wallet_balance_to_users_table', 9),
(16, '2026_04_03_181245_add_fields_to_users_table', 10),
(17, '2026_04_06_164231_add_mlm_fields_to_users_table', 10),
(18, '2026_04_10_191654_create_notifications_table', 11);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) NOT NULL,
  `type` varchar(255) NOT NULL,
  `notifiable_type` varchar(255) NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `payment_id` varchar(255) NOT NULL,
  `order_id` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `method` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `contact` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `user_id`, `payment_id`, `order_id`, `amount`, `method`, `email`, `contact`, `status`, `created_at`, `updated_at`) VALUES
(1, 11, 'pay_SZVBOymeVKf0cG', 'order_SZVBF9FvHUFk3s', 1000.00, 'netbanking', 'balwinder@gmail.com', '+919115620159', 'captured', '2026-04-04 12:12:12', '2026-04-04 12:12:12'),
(2, 11, 'pay_SZVEDnugKxNF2N', 'order_SZVDjr8IFCK0Lz', 1000.00, 'paylater', 'balwinder@gmail.com', '+919115620159', 'captured', '2026-04-04 12:14:52', '2026-04-04 12:14:52'),
(3, 11, 'pay_SaIQgPR77YLMAj', 'order_SaIQZnHDhtL5rz', 1500.00, 'netbanking', 'balwinder@gmail.com', '+919115620159', 'captured', '2026-04-06 12:22:39', '2026-04-06 12:22:39'),
(4, 11, 'pay_SaIUn9brNE8aQi', 'order_SaIUhXJhyYww24', 1500.00, 'netbanking', 'balwinder@gmail.com', '+919115620159', 'captured', '2026-04-06 12:26:28', '2026-04-06 12:26:28'),
(5, 11, 'pay_SaIaoqf10qFp65', 'order_SaIaiANLtIu2SM', 1500.00, 'netbanking', 'balwinder@gmail.com', '+919115620159', 'captured', '2026-04-06 12:32:10', '2026-04-06 12:32:10'),
(6, 11, 'pay_SaIe4nwBWpHCPR', 'order_SaIdxPEHgnVzmi', 1500.00, 'netbanking', 'balwinder@gmail.com', '+919115620159', 'captured', '2026-04-06 12:35:17', '2026-04-06 12:35:17'),
(7, 11, 'pay_SaeyM5hoOtrjVh', 'order_Saey4JCyN6PedI', 1500.00, 'netbanking', 'balwinder@gmail.com', '+919115620159', 'captured', '2026-04-07 10:25:41', '2026-04-07 10:25:41'),
(8, 11, 'pay_Saf1VM4ef8ouFj', 'order_Saf1Pci8OCZQoT', 1500.00, 'netbanking', 'balwinder@gmail.com', '+919115620159', 'captured', '2026-04-07 10:28:39', '2026-04-07 10:28:39'),
(9, 11, 'pay_Saf8XR3aYk9Mf9', 'order_Saf8OjIuh6LwsP', 1500.00, 'netbanking', 'balwinder@gmail.com', '+919115620159', 'captured', '2026-04-07 10:35:20', '2026-04-07 10:35:20'),
(10, 12, 'pay_SafER1CLcIfQeg', 'order_SafE0lXXldUWX2', 1500.00, 'netbanking', 'balwinder@gmail.com', '+919115620159', 'captured', '2026-04-07 10:41:07', '2026-04-07 10:41:07'),
(11, 13, 'pay_SafMUzGLyqmCgQ', 'order_SafMPVxFcaWAr4', 1500.00, 'netbanking', 'balwinder@gmail.com', '+919115620159', 'captured', '2026-04-07 10:48:38', '2026-04-07 10:48:38'),
(12, 15, 'pay_SafbiUF4824oNF', 'order_SafbaofjBl77NP', 1500.00, 'netbanking', 'balwinder@gmail.com', '+919115620159', 'captured', '2026-04-07 11:02:58', '2026-04-07 11:02:58'),
(13, 15, 'pay_SafiBPv0vszT5n', 'order_Safi1fqsxF3gUJ', 1500.00, 'netbanking', 'balwinder@gmail.com', '+919115620159', 'captured', '2026-04-07 11:09:03', '2026-04-07 11:09:03'),
(14, 15, 'pay_SafkEEVhr1698y', 'order_Safk4hqm1eBkTL', 1500.00, 'netbanking', 'balwinder@gmail.com', '+919115620159', 'captured', '2026-04-07 11:11:01', '2026-04-07 11:11:01'),
(15, 16, 'pay_Safme64j5iA4VR', 'order_SafmUnCQa0uslN', 1500.00, 'netbanking', 'balwinder@gmail.com', '+919115620159', 'captured', '2026-04-07 11:13:18', '2026-04-07 11:13:18'),
(16, 17, 'pay_Sagkw7ssLZMXDm', 'order_SagjhTEfzd5YSg', 1500.00, 'netbanking', 'balwinder@gmail.com', '+919115620159', 'captured', '2026-04-07 12:10:27', '2026-04-07 12:10:27'),
(17, 18, 'pay_SaguQTTmg4I8hD', 'order_SaguJ8zL0m7a52', 1500.00, 'netbanking', 'balwinder@gmail.com', '+919115620159', 'captured', '2026-04-07 12:19:20', '2026-04-07 12:19:20'),
(18, 19, 'pay_Sah0960J1aBDgq', 'order_SagzzSbe9jgLRm', 1500.00, 'netbanking', 'balwinder@gmail.com', '+919115620159', 'captured', '2026-04-07 12:24:45', '2026-04-07 12:24:45'),
(19, 20, 'pay_Sah3krYd4jw0ym', 'order_Sah3fi6yHdbMQb', 1500.00, 'netbanking', 'balwinder@gmail.com', '+919115620159', 'captured', '2026-04-07 12:28:15', '2026-04-07 12:28:15'),
(20, 21, 'pay_Sb4UYvBeAhJo81', 'order_Sb4UFJfIYHMgbd', 1500.00, 'netbanking', 'void@razorpay.com', '+917888322925', 'captured', '2026-04-08 11:24:07', '2026-04-08 11:24:07'),
(21, 22, 'pay_SbOwF8AUW2hKS7', 'order_SbOw7Qhm9q9bwH', 1500.00, 'netbanking', 'void@razorpay.com', '+917888322925', 'captured', '2026-04-09 07:24:10', '2026-04-09 07:24:10'),
(22, 23, 'pay_SbP7kvJ8cPPJKj', 'order_SbP7YCBfwftfXg', 1500.00, 'netbanking', 'void@razorpay.com', '+917888322925', 'captured', '2026-04-09 07:35:18', '2026-04-09 07:35:18'),
(23, 24, 'pay_SbPdNvyqyj9V6u', 'order_SbPd8w4hQn8mhj', 1500.00, 'netbanking', 'void@razorpay.com', '+917888322925', 'captured', '2026-04-09 08:05:03', '2026-04-09 08:05:03'),
(24, 25, 'pay_SbQFoZBrKQN0j0', 'order_SbQFi7MhW1Mgdp', 1500.00, 'netbanking', 'void@razorpay.com', '+917888322925', 'captured', '2026-04-09 08:41:25', '2026-04-09 08:41:25'),
(25, 26, 'pay_SbQJCeusp7MfYf', 'order_SbQJ73T8dgzr2s', 1500.00, 'wallet', 'void@razorpay.com', '+917888322925', 'captured', '2026-04-09 08:44:36', '2026-04-09 08:44:36'),
(26, 27, 'pay_SbQWmIUEBvV6ZU', 'order_SbQWhBN8yHmSiQ', 1500.00, 'netbanking', 'void@razorpay.com', '+917888322925', 'captured', '2026-04-09 08:57:26', '2026-04-09 08:57:26'),
(27, 28, 'pay_SbQeeAfgphgnoV', 'order_SbQe3uciKCZFm2', 1500.00, 'wallet', 'void@razorpay.com', '+917888322925', 'captured', '2026-04-09 09:05:00', '2026-04-09 09:05:00'),
(28, 29, 'pay_SbQs5dQEgsPjyf', 'order_SbQs1nu3JQOB16', 1500.00, 'netbanking', 'void@razorpay.com', '+917888322925', 'captured', '2026-04-09 09:17:38', '2026-04-09 09:17:38'),
(29, 30, 'pay_SbQwszt7f0yl74', 'order_SbQwncP91Om1K8', 1500.00, 'netbanking', 'void@razorpay.com', '+917888322925', 'captured', '2026-04-09 09:22:19', '2026-04-09 09:22:19'),
(30, 31, 'pay_SbU3anzoBv7QqW', 'order_SbU3OcwY8Y4bwI', 1500.00, 'netbanking', 'void@razorpay.com', '+917888322925', 'captured', '2026-04-09 12:24:38', '2026-04-09 12:24:38'),
(31, 32, 'pay_SbUA875OvjDWGp', 'order_SbUA3VfDX1lnli', 1500.00, 'netbanking', 'void@razorpay.com', '+917888322925', 'captured', '2026-04-09 12:30:52', '2026-04-09 12:30:52'),
(32, 33, 'pay_SbsaWcgsVpUPih', 'order_SbsaLXBHGqkLQo', 1500.00, 'netbanking', 'void@razorpay.com', '+918567073087', 'captured', '2026-04-10 12:24:29', '2026-04-10 12:24:29'),
(33, 34, 'pay_SbskDH68dDHl5r', 'order_Sbsk4pMnrwwWVe', 1500.00, 'netbanking', 'void@razorpay.com', '+918567073087', 'captured', '2026-04-10 12:33:40', '2026-04-10 12:33:40'),
(34, 35, 'pay_SbuVaXRqsHLBz5', 'order_SbuVEnMMc1TS9b', 1500.00, 'netbanking', 'void@razorpay.com', '+918567073087', 'captured', '2026-04-10 14:17:07', '2026-04-10 14:17:07'),
(35, 36, 'pay_ScIKzXzROjqLz7', 'order_ScIKbdAGxfBBDv', 1500.00, 'netbanking', 'void@razorpay.com', '+917888322925', 'captured', '2026-04-11 13:35:47', '2026-04-11 13:35:47');

-- --------------------------------------------------------

--
-- Table structure for table `phone_verifications`
--

CREATE TABLE `phone_verifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `phone` varchar(255) NOT NULL,
  `otp` varchar(255) NOT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT 0,
  `expires_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `phone_verifications`
--

INSERT INTO `phone_verifications` (`id`, `phone`, `otp`, `is_verified`, `expires_at`, `created_at`, `updated_at`) VALUES
(5, '9115620159', '581543', 1, '2026-04-07 18:07:09', '2026-04-03 12:50:36', '2026-04-07 12:27:20'),
(6, '7888322925', '162349', 1, '2026-04-11 19:12:09', '2026-04-08 11:22:08', '2026-04-11 13:33:25'),
(7, '8567073087', '713558', 0, '2026-04-09 13:10:44', '2026-04-09 07:29:00', '2026-04-09 07:30:44');

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

CREATE TABLE `plans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `base_value` int(11) NOT NULL,
  `daily_cap` int(11) NOT NULL,
  `total_cap` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `plans`
--

INSERT INTO `plans` (`id`, `name`, `price`, `base_value`, `daily_cap`, `total_cap`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Plan A', 1500, 1000, 2000, 10000, 1, '2026-04-11 13:55:08', '2026-04-11 13:55:08'),
(2, 'Plan B', 2500, 2500, 5000, 25000, 1, '2026-04-11 13:55:08', '2026-04-11 13:55:08'),
(3, 'Plan C', 5000, 5000, 10000, 50000, 1, '2026-04-11 13:55:08', '2026-04-11 13:55:08'),
(4, 'Plan D', 10000, 10000, 20000, 100000, 1, '2026-04-11 13:55:08', '2026-04-11 13:55:08'),
(5, 'Plan E', 20000, 20000, 40000, 200000, 1, '2026-04-11 13:55:08', '2026-04-11 13:55:08');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `short_desc` varchar(500) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `original_price` decimal(10,2) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `benefits` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `tags` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `rating` decimal(3,2) NOT NULL DEFAULT 0.00,
  `review_count` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `sku` varchar(255) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `slug`, `category`, `description`, `short_desc`, `price`, `original_price`, `image`, `benefits`, `tags`, `stock`, `rating`, `review_count`, `status`, `sku`, `sort_order`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Giloy Juice', 'giloy-juice', 'immunity', NULL, 'Pure Giloy stem juice for daily immunity boost & fever management.', 299.00, 399.00, NULL, '[\"Immunity\",\"Anti-viral\",\"Antioxidant\"]', '[\"Best\"]', 150, 4.80, 210, 'active', NULL, 0, '2026-03-29 09:18:22', '2026-03-29 09:18:22', NULL),
(2, 'Tulsi Drops', 'tulsi-drops', 'immunity', NULL, 'Concentrated holy basil extract for respiratory health & immunity.', 199.00, 299.00, NULL, '[\"Cold & Flu\",\"Respiratory\",\"Immunity\"]', '[\"Sale\"]', 200, 4.70, 180, 'active', NULL, 0, '2026-03-29 09:18:22', '2026-03-29 09:18:22', NULL),
(3, 'Chyawanprash Classic', 'chyawanprash-classic', 'immunity', NULL, 'Traditional herbal jam with 40+ herbs. India\'s number 1 immunity formula.', 499.00, 699.00, NULL, '[\"Immunity\",\"Energy\",\"Anti-ageing\"]', '[\"Best\"]', 120, 4.90, 340, 'active', NULL, 0, '2026-03-29 09:18:22', '2026-03-29 09:18:22', NULL),
(4, 'Amla Gold Capsules', 'amla-gold-capsules', 'immunity', NULL, 'High-potency Indian gooseberry extract for daily immunity support.', 399.00, 499.00, NULL, '[\"Vitamin C\",\"Immunity\",\"Antioxidant\"]', '[\"New\"]', 90, 4.60, 150, 'active', NULL, 0, '2026-03-29 09:18:22', '2026-03-29 09:18:22', NULL),
(5, 'Triphala Churna', 'triphala-churna', 'digestion', NULL, 'Three-fruit blend for complete digestive wellness & gentle detox.', 249.00, 349.00, NULL, '[\"Digestion\",\"Detox\",\"Constipation Relief\"]', '[\"Best\"]', 175, 4.70, 195, 'active', NULL, 0, '2026-03-29 09:18:22', '2026-03-29 09:18:22', NULL),
(6, 'Aloe Vera Juice', 'aloe-vera-juice', 'digestion', NULL, 'Pure aloe vera juice for gut health, skin glow & digestion.', 299.00, 399.00, NULL, '[\"Gut Health\",\"Digestion\",\"Skin\"]', '[\"Sale\"]', 160, 4.50, 220, 'active', NULL, 0, '2026-03-29 09:18:22', '2026-03-29 09:18:22', NULL),
(7, 'Isabgol Husk', 'isabgol-husk', 'digestion', NULL, 'Natural psyllium husk for smooth digestion & healthy cholesterol levels.', 199.00, NULL, NULL, '[\"Fiber\",\"Constipation\",\"Cholesterol\"]', '[]', 200, 4.60, 310, 'active', NULL, 0, '2026-03-29 09:18:22', '2026-03-29 09:18:22', NULL),
(8, 'Kumkumadi Oil', 'kumkumadi-oil', 'skincare', NULL, 'Ayurvedic face oil with saffron for radiant & youthful skin.', 899.00, 1299.00, NULL, '[\"Glow\",\"Anti-ageing\",\"Dark Spots\"]', '[\"Best\",\"Sale\"]', 60, 4.80, 175, 'active', NULL, 0, '2026-03-29 09:18:22', '2026-03-29 09:18:22', NULL),
(9, 'Neem Face Wash', 'neem-face-wash', 'skincare', NULL, 'Neem & turmeric face wash for acne-free, clear skin.', 299.00, 399.00, NULL, '[\"Acne\",\"Oil Control\",\"Antibacterial\"]', '[\"New\"]', 180, 4.50, 280, 'active', NULL, 0, '2026-03-29 09:18:22', '2026-03-29 09:18:22', NULL),
(10, 'Bhringraj Hair Oil', 'bhringraj-hair-oil', 'haircare', NULL, 'Bhringraj & Amla oil for hair growth, dandruff control & shine.', 449.00, 599.00, NULL, '[\"Hair Growth\",\"Anti-dandruff\",\"Strengthening\"]', '[\"Best\"]', 130, 4.70, 240, 'active', NULL, 0, '2026-03-29 09:18:22', '2026-03-29 09:18:22', NULL),
(11, 'Onion Hair Serum', 'onion-hair-serum', 'haircare', NULL, 'Onion extract serum to reduce hair fall and strengthen roots.', 599.00, 799.00, NULL, '[\"Hair Fall\",\"Scalp Health\",\"Nourishment\"]', '[\"Sale\"]', 100, 4.60, 190, 'active', NULL, 0, '2026-03-29 09:18:22', '2026-03-29 09:18:22', NULL),
(12, 'Shallaki Capsules', 'shallaki-capsules', 'joint', NULL, 'Boswellia extract capsules for joint flexibility & pain relief.', 549.00, 749.00, NULL, '[\"Joint Pain\",\"Inflammation\",\"Mobility\"]', '[\"Best\"]', 80, 4.60, 145, 'active', NULL, 0, '2026-03-29 09:18:22', '2026-03-29 09:18:22', NULL),
(13, 'Ashwagandha KSM-66', 'ashwagandha-ksm-66', 'energy', NULL, 'Clinically studied root extract for energy, vitality & stress management.', 699.00, 999.00, NULL, '[\"Stress Relief\",\"Energy\",\"Testosterone\"]', '[\"Best\"]', 200, 4.90, 420, 'active', NULL, 0, '2026-03-29 09:18:22', '2026-03-29 09:18:22', NULL),
(14, 'Neem Karela Jamun', 'neem-karela-jamun', 'detox', NULL, 'Powerful blood purifier for blood sugar management & liver detox.', 349.00, 499.00, NULL, '[\"Blood Sugar\",\"Detox\",\"Liver Health\"]', '[\"Sale\"]', 140, 4.50, 165, 'active', NULL, 0, '2026-03-29 09:18:22', '2026-03-29 09:18:22', NULL),
(15, 'Wheatgrass Powder', 'wheatgrass-powder', 'detox', NULL, 'Pure organic wheatgrass powder for alkalizing & natural detox.', 399.00, 549.00, NULL, '[\"Chlorophyll\",\"Detox\",\"Energy\"]', '[\"New\"]', 110, 4.40, 130, 'active', NULL, 0, '2026-03-29 09:18:22', '2026-03-29 09:18:22', NULL),
(16, 'Shatavari Capsules', 'shatavari-capsules', 'women', NULL, 'Shatavari root extract for hormonal balance & women\'s reproductive health.', 499.00, 699.00, NULL, '[\"Hormonal Balance\",\"Fertility\",\"Lactation\"]', '[\"Best\"]', 95, 4.70, 155, 'active', NULL, 0, '2026-03-29 09:18:22', '2026-03-29 09:18:22', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `recently_viewed`
--

CREATE TABLE `recently_viewed` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `viewed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `reference_code` varchar(50) DEFAULT NULL,
  `referred_by` bigint(20) UNSIGNED DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` enum('active','inactive','blocked') NOT NULL DEFAULT 'inactive',
  `has_plan` tinyint(1) NOT NULL DEFAULT 0,
  `current_plan_id` bigint(20) UNSIGNED DEFAULT NULL,
  `wallet_balance` decimal(12,2) NOT NULL DEFAULT 0.00,
  `total_earned` decimal(12,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_id`, `name`, `email`, `phone`, `reference_code`, `referred_by`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `status`, `has_plan`, `current_plan_id`, `wallet_balance`, `total_earned`) VALUES
(1, '', 'deepak', 'kambojdeepak957@gmail.com', NULL, NULL, NULL, NULL, '$2y$12$rYWOw4RFNvSQ124A5jjXhu46U2D9gKcBZZyVYe5LDpXVzFho8tABO', NULL, '2026-03-01 02:48:42', '2026-03-01 02:48:42', 'inactive', 0, NULL, 0.00, 0.00),
(2, '', 'palak', 'palakdogra94@gmail.com', NULL, NULL, NULL, NULL, '$2y$12$7xIV9Btn7ILKS8D36BGq9.Lj1vuopRnDFgBXQSJ75GT5.larXnr4.', 'f989yYuHFrSWCSHBIgoafrICLF4PIJWY2iQlwboeYZO9kmop2JIjGgAtkSeW', '2026-03-01 03:18:54', '2026-03-01 03:18:54', 'inactive', 0, NULL, 0.00, 0.00),
(3, '', 'sanju', 'sanju@gmail.com', NULL, NULL, NULL, NULL, '$2y$12$SqXxov3Fye/DzjJCnY9Ope5oILfFWqws.H2Xyc0/NSuqOMnv3GmAy', NULL, '2026-03-01 11:52:53', '2026-03-01 11:52:53', 'inactive', 0, NULL, 0.00, 0.00),
(4, '', 'KEMTEX', 'kemtex@gmail.com', '1234567890', NULL, NULL, NULL, '$2y$12$Hq26oB4Zqvv6UKkmaNZcjeaa5Mqi364Yh56fS1V3ZOMNt/zexRZ5q', NULL, '2026-03-08 06:16:20', '2026-03-08 06:16:20', 'inactive', 0, NULL, 0.00, 0.00),
(5, '', 'Lovedeep', 'lovedeep@gmail.com', '1234567890', NULL, NULL, NULL, '$2y$12$kxle8VlSRXAuTzndIvYwSOTc0LarGNr6y8VLM7YRc6ZGUOBwYirMK', NULL, '2026-03-08 07:48:56', '2026-03-08 07:48:56', 'inactive', 0, NULL, 0.00, 0.00),
(6, '', 'SARFARAZ ALAM', 'KEMTEX.PETROCHEMICALSCO@GMAIL.COM', '9563581660', NULL, NULL, NULL, '$2y$12$fXjKPzKbpyUYpd/3lIp41uduxPWaSMwdhPMxk5hglrlUSEKvh0hZy', NULL, '2026-03-08 08:45:35', '2026-03-08 08:45:35', 'inactive', 0, NULL, 0.00, 0.00),
(7, '', 'Sanjeev Kamboj', 'sanjeevkamboj132@gmail.com', '8054530498', NULL, NULL, NULL, '$2y$12$cPE5tUGihT9CIjif1xa3AOAUIpJQTH3SSW0qhjWr4sDEvO80JfmN2', NULL, '2026-03-22 11:29:02', '2026-03-22 11:29:02', 'inactive', 0, NULL, 0.00, 0.00),
(8, '', 'Sunil', 'sunil@gmail.com', '9876543217', NULL, NULL, NULL, '$2y$12$22VYvLdMsur8fxFY.QQdNOXIPClhtimt9VQZUaSVxtt7fUuiBXq82', NULL, '2026-03-22 11:44:05', '2026-03-22 11:44:05', 'inactive', 0, NULL, 0.00, 0.00),
(9, '', 'Deepak kamboj', 'kambojdeepak439@gmail.com', '9876543210', NULL, NULL, NULL, '$2y$12$qrDqBbKPcDv3FHXzUusGXO7Pbd2/Tfy0uEEii5e2Xt3I5I.kTZV/G', 'luPltynNr0KKeYF1WKe5RReMLJ4sagK7yv0jxiMYzRQK7vDDi5fYzjnNRNvc', '2026-03-29 09:04:25', '2026-03-29 09:04:25', 'inactive', 0, NULL, 0.00, 0.00),
(11, NULL, 'Balwinder Kaur', 'balwinder@gmail.com', '9888186886', 'REFEDIB9N', NULL, NULL, '$2y$12$Uh08oo1womxm1GYuDUeGEeHTKDPw40v1ogHSNZr/0XH0PJeBcuhMW', 'IlcbWvYVRNqy29nNUkzXPwbuGHskqSzQzlKa1oxLjHyETS5gBQA76cJYcou5', '2026-04-03 13:06:52', '2026-04-07 10:35:20', 'active', 1, 1, 0.00, 0.00),
(15, NULL, 'Balwinder Kaur', 'balwinder2@mailinator.com', '9638527415', 'REFIWB7CF', 11, NULL, '$2y$12$iSsXxDw4nCHJbTMN1OnVSua3Ft42eOQtwQTxvthGj.KF2EEV6QYkq', NULL, '2026-04-07 11:02:13', '2026-04-07 11:11:01', 'active', 1, 1, 0.00, 0.00),
(17, NULL, 'Balwinder Kaur', 'balwinder3@mailinator.com', '9632587412', 'REF3DWLZE', 15, NULL, '$2y$12$4kHtvC88AQMal8sZq7xPVebknmbzEoz4ECTTgAXyy.SfvnELBmSZK', NULL, '2026-04-07 12:08:15', '2026-04-07 12:10:27', 'active', 1, 1, 0.00, 0.00),
(18, NULL, 'Balwinder Kaur', 'balwinder4@mailinator.com', '9632587415', 'REF9AGKUE', 17, NULL, '$2y$12$yS9ny.L99MCgudAu5HRSce5J3W2Mu0S4njw3RD8WkdAzLx7qPeh2S', NULL, '2026-04-07 12:18:47', '2026-04-07 12:19:20', 'active', 1, 1, 0.00, 0.00),
(19, NULL, 'Balwinder Kaur', 'balwinder5@mailinator.com', '9632145874', 'REFFHZLX7', 18, NULL, '$2y$12$z5K4.DCFHIfyvJYfZEjESehG.dUMb9OAD/i93dbSy2YxoL/Qxyzw2', NULL, '2026-04-07 12:24:15', '2026-04-07 12:24:45', 'active', 1, 1, 0.00, 0.00),
(20, NULL, 'Balwinder Kaur', 'balwinder56@mailinator.com', '9115620159', 'REFNM7Z4D', 19, NULL, '$2y$12$ka1k0vLO/7r3rmX2hS7lVOXWjw1Dw0Qb9bwlDF2FpYckJZ4i.ZkRe', '0cC05bPRV5kxlbTUz63EPd0oOJ2z1s4iAZ8xkn61mGCu9zeQ4DVIE7w0Arbw', '2026-04-07 12:27:44', '2026-04-07 12:28:15', 'active', 1, 1, 0.00, 0.00),
(21, NULL, 'palak', 'palak@mailinator.com', '7888322926', 'REFGBYNCY', NULL, NULL, '$2y$12$ggYLRucIxWfMedsBMK0TA.Xmp.ONUFT5hqosvOAIo6lXBqGqc6Dmq', NULL, '2026-04-08 11:23:23', '2026-04-08 11:24:07', 'active', 1, 1, 0.00, 0.00),
(25, NULL, 'Palak', 'palak@gmail.com', '7888322929', 'REF8CZXRM', NULL, NULL, '$2y$12$034JgtvkwW5lRsHyNx4KAO1CCU0UnZBNIwwZUrO/tEoMfOGMOHf12', '3WHvUZQY9p5fFPOZ63bCNQ0e4uO65QdL9unsS4kuppKK9zNMgnyIUb3EGSYh', '2026-04-09 08:40:58', '2026-04-09 08:41:25', 'active', 1, 1, 0.00, 0.00),
(26, NULL, 'PLK Kamboj', 'palakk@gmail.com', '9814342918', 'REFF0NUAK', 25, NULL, '$2y$12$ka1k0vLO/7r3rmX2hS7lVOXWjw1Dw0Qb9bwlDF2FpYckJZ4i.ZkRe', NULL, '2026-04-09 08:44:11', '2026-04-09 08:44:36', 'active', 1, 1, 0.00, 0.00),
(27, NULL, 'Sunita', 'Sunita@gmail.com', '7808322925', 'REFDMPM9F', 26, NULL, '$2y$12$FLX.uc9Kl58W9r9SjUhvFONoEp2CPq2onFng1XGDqiu.yJHu/FBd6', NULL, '2026-04-09 08:57:04', '2026-04-09 08:57:26', 'active', 1, 1, 0.00, 0.00),
(28, NULL, 'Ram', 'ram@gmail.com', '7888622925', 'REFZICVOA', 27, NULL, '$2y$12$d6/noVt6yQNOs9UTezU0fevokO3P1hj3Vs5oHU1mtrdtMq6Cs2jgq', NULL, '2026-04-09 09:04:02', '2026-04-09 09:05:00', 'active', 1, 1, 0.00, 0.00),
(29, NULL, 'Sam', 'Sam@gmail.com', '0', 'REF1D5VHV', 28, NULL, '$2y$12$Azs6tKjWYcNoW8tLBGUJCe05lzkg6wqvKwYJ5nSx4rOCOSVAIR8z.', NULL, '2026-04-09 09:17:16', '2026-04-09 09:17:38', 'active', 1, 1, 0.00, 0.00),
(30, NULL, 'Sajan', 'sajan@gmail.com', '7808322925', 'REFB2JE92', 29, NULL, '$2y$12$Gbjq4g8.9KNZXJ/DYbp/cuAA.0xafNibX7qWWix7OCyx7C7lFihlC', NULL, '2026-04-09 09:21:45', '2026-04-09 09:22:19', 'active', 1, 1, 0.00, 0.00),
(31, NULL, 'shubham', 'shubh@gmail.com', '7888302925', 'REFMPNBZQ', 30, NULL, '$2y$12$I7JRMlm3fDo69wLYPbfYF.GxcDPpy0VKS9Mm9ppXWJ3PIaGQp/tWi', NULL, '2026-04-09 12:24:04', '2026-04-09 12:24:38', 'active', 1, 1, 0.00, 0.00),
(32, NULL, 'kamboj', 'kamboj@gmail.com', '7888322928', 'REFE0TQVS', 31, NULL, '$2y$12$DdLzDXBjKj9CYtzbnfCVAuEOQsR..7aK7I3Zu4R8S3ZG6BoIjLgyu', NULL, '2026-04-09 12:30:21', '2026-04-09 12:30:52', 'active', 1, 1, 0.00, 0.00),
(33, NULL, 'Sapna', 'sapna@mailinator.com', '7880322925', 'REFMNA0EL', NULL, NULL, '$2y$12$034JgtvkwW5lRsHyNx4KAO1CCU0UnZBNIwwZUrO/tEoMfOGMOHf12', NULL, '2026-04-10 12:23:12', '2026-04-10 12:24:29', 'active', 1, 1, 0.00, 0.00),
(34, NULL, 'Bebo Dogra', 'Bebo@gmail.com', '7188322925', 'REFQFRLZ9', 28, NULL, '$2y$12$kg3dgZVaLP/qoFNBMXO7d.8W5bpRxeE58yw2w6kEUp3LyRJkuMc.a', NULL, '2026-04-10 12:33:04', '2026-04-10 12:33:40', 'active', 1, 1, 0.00, 0.00),
(35, NULL, 'sugriv', 'sugriv@mailinator.com', '7888302925', 'REF8ZB4DG', 25, NULL, '$2y$12$8klat.iEzV2YvPd7R49ryexpC0y.65A6RypP.AyE4/tUJEIpN30cG', NULL, '2026-04-10 14:01:59', '2026-04-10 14:17:07', 'active', 1, 1, 0.00, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `user_plans`
--

CREATE TABLE `user_plans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `plan_id` bigint(20) UNSIGNED NOT NULL,
  `amount_paid` int(11) NOT NULL,
  `status` enum('active','upgraded') NOT NULL,
  `activated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_plans`
--

INSERT INTO `user_plans` (`id`, `user_id`, `plan_id`, `amount_paid`, `status`, `activated_at`, `created_at`, `updated_at`) VALUES
(4, 11, 1, 1500, 'active', '2026-04-06 12:35:17', '2026-04-06 12:35:17', '2026-04-06 12:35:17'),
(5, 11, 1, 1500, 'active', '2026-04-07 10:25:41', '2026-04-07 10:25:41', '2026-04-07 10:25:41'),
(6, 11, 1, 1500, 'active', '2026-04-07 10:28:40', '2026-04-07 10:28:40', '2026-04-07 10:28:40'),
(7, 11, 1, 1500, 'active', '2026-04-07 10:35:20', '2026-04-07 10:35:20', '2026-04-07 10:35:20'),
(10, 15, 1, 1500, 'active', '2026-04-07 11:02:58', '2026-04-07 11:02:58', '2026-04-07 11:02:58'),
(11, 15, 1, 1500, 'active', '2026-04-07 11:09:03', '2026-04-07 11:09:03', '2026-04-07 11:09:03'),
(12, 15, 1, 1500, 'active', '2026-04-07 11:11:01', '2026-04-07 11:11:01', '2026-04-07 11:11:01'),
(14, 17, 1, 1500, 'active', '2026-04-07 12:10:27', '2026-04-07 12:10:27', '2026-04-07 12:10:27'),
(15, 18, 1, 1500, 'active', '2026-04-07 12:19:20', '2026-04-07 12:19:20', '2026-04-07 12:19:20'),
(16, 19, 1, 1500, 'active', '2026-04-07 12:24:45', '2026-04-07 12:24:45', '2026-04-07 12:24:45'),
(17, 20, 1, 1500, 'active', '2026-04-07 12:28:15', '2026-04-07 12:28:15', '2026-04-07 12:28:15'),
(18, 21, 1, 1500, 'active', '2026-04-08 11:24:07', '2026-04-08 11:24:07', '2026-04-08 11:24:07'),
(22, 25, 1, 1500, 'active', '2026-04-09 08:41:25', '2026-04-09 08:41:25', '2026-04-09 08:41:25'),
(23, 26, 1, 1500, 'active', '2026-04-09 08:44:36', '2026-04-09 08:44:36', '2026-04-09 08:44:36'),
(24, 27, 1, 1500, 'active', '2026-04-09 08:57:26', '2026-04-09 08:57:26', '2026-04-09 08:57:26'),
(25, 28, 1, 1500, 'active', '2026-04-09 09:05:00', '2026-04-09 09:05:00', '2026-04-09 09:05:00'),
(26, 29, 1, 1500, 'active', '2026-04-09 09:17:38', '2026-04-09 09:17:38', '2026-04-09 09:17:38'),
(27, 30, 1, 1500, 'active', '2026-04-09 09:22:19', '2026-04-09 09:22:19', '2026-04-09 09:22:19'),
(28, 31, 1, 1500, 'active', '2026-04-09 12:24:38', '2026-04-09 12:24:38', '2026-04-09 12:24:38'),
(29, 32, 1, 1500, 'active', '2026-04-09 12:30:52', '2026-04-09 12:30:52', '2026-04-09 12:30:52'),
(30, 33, 1, 1500, 'active', '2026-04-10 12:24:29', '2026-04-10 12:24:29', '2026-04-10 12:24:29'),
(31, 34, 1, 1500, 'active', '2026-04-10 12:33:40', '2026-04-10 12:33:40', '2026-04-10 12:33:40'),
(32, 35, 1, 1500, 'active', '2026-04-10 14:17:07', '2026-04-10 14:17:07', '2026-04-10 14:17:07');

-- --------------------------------------------------------

--
-- Table structure for table `user_tree`
--

CREATE TABLE `user_tree` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `upline_id` bigint(20) UNSIGNED NOT NULL,
  `level` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_tree`
--

INSERT INTO `user_tree` (`id`, `user_id`, `upline_id`, `level`, `created_at`, `updated_at`) VALUES
(1, 15, 11, 1, '2026-04-07 11:02:13', '2026-04-07 11:02:13'),
(3, 17, 15, 1, '2026-04-07 12:08:15', '2026-04-07 12:08:15'),
(4, 17, 11, 2, '2026-04-07 12:08:15', '2026-04-07 12:08:15'),
(5, 18, 17, 1, '2026-04-07 12:18:47', '2026-04-07 12:18:47'),
(6, 18, 15, 2, '2026-04-07 12:18:47', '2026-04-07 12:18:47'),
(7, 18, 11, 3, '2026-04-07 12:18:47', '2026-04-07 12:18:47'),
(8, 19, 18, 1, '2026-04-07 12:24:15', '2026-04-07 12:24:15'),
(9, 19, 17, 2, '2026-04-07 12:24:15', '2026-04-07 12:24:15'),
(10, 19, 15, 3, '2026-04-07 12:24:15', '2026-04-07 12:24:15'),
(11, 19, 11, 4, '2026-04-07 12:24:15', '2026-04-07 12:24:15'),
(12, 20, 19, 1, '2026-04-07 12:27:44', '2026-04-07 12:27:44'),
(13, 20, 18, 2, '2026-04-07 12:27:44', '2026-04-07 12:27:44'),
(14, 20, 17, 3, '2026-04-07 12:27:44', '2026-04-07 12:27:44'),
(15, 20, 15, 4, '2026-04-07 12:27:44', '2026-04-07 12:27:44'),
(16, 20, 11, 5, '2026-04-07 12:27:44', '2026-04-07 12:27:44'),
(17, 26, 25, 1, '2026-04-09 08:44:11', '2026-04-09 08:44:11'),
(18, 27, 26, 1, '2026-04-09 08:57:04', '2026-04-09 08:57:04'),
(19, 27, 25, 2, '2026-04-09 08:57:04', '2026-04-09 08:57:04'),
(20, 28, 27, 1, '2026-04-09 09:04:02', '2026-04-09 09:04:02'),
(21, 28, 26, 2, '2026-04-09 09:04:02', '2026-04-09 09:04:02'),
(22, 28, 25, 3, '2026-04-09 09:04:02', '2026-04-09 09:04:02'),
(23, 29, 28, 1, '2026-04-09 09:17:16', '2026-04-09 09:17:16'),
(24, 29, 27, 2, '2026-04-09 09:17:16', '2026-04-09 09:17:16'),
(25, 29, 26, 3, '2026-04-09 09:17:16', '2026-04-09 09:17:16'),
(26, 29, 25, 4, '2026-04-09 09:17:16', '2026-04-09 09:17:16'),
(27, 30, 29, 1, '2026-04-09 09:21:45', '2026-04-09 09:21:45'),
(28, 30, 28, 2, '2026-04-09 09:21:46', '2026-04-09 09:21:46'),
(29, 30, 27, 3, '2026-04-09 09:21:46', '2026-04-09 09:21:46'),
(30, 30, 26, 4, '2026-04-09 09:21:46', '2026-04-09 09:21:46'),
(31, 30, 25, 5, '2026-04-09 09:21:46', '2026-04-09 09:21:46'),
(32, 31, 30, 1, '2026-04-09 12:24:04', '2026-04-09 12:24:04'),
(33, 31, 29, 2, '2026-04-09 12:24:04', '2026-04-09 12:24:04'),
(34, 31, 28, 3, '2026-04-09 12:24:04', '2026-04-09 12:24:04'),
(35, 31, 27, 4, '2026-04-09 12:24:04', '2026-04-09 12:24:04'),
(36, 31, 26, 5, '2026-04-09 12:24:04', '2026-04-09 12:24:04'),
(37, 31, 25, 6, '2026-04-09 12:24:04', '2026-04-09 12:24:04'),
(38, 32, 31, 1, '2026-04-09 12:30:21', '2026-04-09 12:30:21'),
(39, 32, 30, 2, '2026-04-09 12:30:21', '2026-04-09 12:30:21'),
(40, 32, 29, 3, '2026-04-09 12:30:21', '2026-04-09 12:30:21'),
(41, 32, 28, 4, '2026-04-09 12:30:21', '2026-04-09 12:30:21'),
(42, 32, 27, 5, '2026-04-09 12:30:21', '2026-04-09 12:30:21'),
(43, 32, 26, 6, '2026-04-09 12:30:21', '2026-04-09 12:30:21'),
(44, 32, 25, 7, '2026-04-09 12:30:21', '2026-04-09 12:30:21'),
(45, 34, 28, 1, '2026-04-10 12:33:04', '2026-04-10 12:33:04'),
(46, 34, 27, 2, '2026-04-10 12:33:04', '2026-04-10 12:33:04'),
(47, 34, 26, 3, '2026-04-10 12:33:04', '2026-04-10 12:33:04'),
(48, 34, 25, 4, '2026-04-10 12:33:04', '2026-04-10 12:33:04'),
(49, 35, 25, 1, '2026-04-10 14:01:59', '2026-04-10 14:01:59');

-- --------------------------------------------------------

--
-- Table structure for table `wishlists`
--

CREATE TABLE `wishlists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `carts_user_id_product_id_unique` (`user_id`,`product_id`),
  ADD KEY `carts_user_id_index` (`user_id`),
  ADD KEY `carts_product_id_index` (`product_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `incomes`
--
ALTER TABLE `incomes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `incomes_user_id_index` (`user_id`),
  ADD KEY `incomes_from_user_id_index` (`from_user_id`),
  ADD KEY `incomes_level_index` (`level`),
  ADD KEY `incomes_status_index` (`status`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`(191));

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `phone_verifications`
--
ALTER TABLE `phone_verifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `recently_viewed`
--
ALTER TABLE `recently_viewed`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `recently_viewed_user_id_product_id_unique` (`user_id`,`product_id`),
  ADD KEY `recently_viewed_product_id_foreign` (`product_id`),
  ADD KEY `recently_viewed_user_id_viewed_at_index` (`user_id`,`viewed_at`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_referred_by_foreign` (`referred_by`);

--
-- Indexes for table `user_plans`
--
ALTER TABLE `user_plans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_plans_user_id_foreign` (`user_id`),
  ADD KEY `user_plans_plan_id_foreign` (`plan_id`);

--
-- Indexes for table `user_tree`
--
ALTER TABLE `user_tree`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_tree_user_id_index` (`user_id`),
  ADD KEY `user_tree_upline_id_index` (`upline_id`),
  ADD KEY `user_tree_level_index` (`level`);

--
-- Indexes for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `wishlists_user_id_product_id_unique` (`user_id`,`product_id`),
  ADD KEY `wishlists_user_id_index` (`user_id`),
  ADD KEY `wishlists_product_id_index` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `incomes`
--
ALTER TABLE `incomes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `phone_verifications`
--
ALTER TABLE `phone_verifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `plans`
--
ALTER TABLE `plans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `recently_viewed`
--
ALTER TABLE `recently_viewed`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `user_plans`
--
ALTER TABLE `user_plans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `user_tree`
--
ALTER TABLE `user_tree`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `incomes`
--
ALTER TABLE `incomes`
  ADD CONSTRAINT `incomes_from_user_id_foreign` FOREIGN KEY (`from_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `incomes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_referred_by_foreign` FOREIGN KEY (`referred_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `user_plans`
--
ALTER TABLE `user_plans`
  ADD CONSTRAINT `user_plans_plan_id_foreign` FOREIGN KEY (`plan_id`) REFERENCES `plans` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_plans_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_tree`
--
ALTER TABLE `user_tree`
  ADD CONSTRAINT `user_tree_upline_id_foreign` FOREIGN KEY (`upline_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_tree_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
