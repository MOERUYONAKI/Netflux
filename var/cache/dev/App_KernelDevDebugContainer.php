<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\ContainerDdcWFZs\App_KernelDevDebugContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/ContainerDdcWFZs/App_KernelDevDebugContainer.php') {
    touch(__DIR__.'/ContainerDdcWFZs.legacy');

    return;
}

if (!\class_exists(App_KernelDevDebugContainer::class, false)) {
    \class_alias(\ContainerDdcWFZs\App_KernelDevDebugContainer::class, App_KernelDevDebugContainer::class, false);
}

return new \ContainerDdcWFZs\App_KernelDevDebugContainer([
    'container.build_hash' => 'DdcWFZs',
    'container.build_id' => 'a8b2d420',
    'container.build_time' => 1731058855,
    'container.runtime_mode' => \in_array(\PHP_SAPI, ['cli', 'phpdbg', 'embed'], true) ? 'web=0' : 'web=1',
], __DIR__.\DIRECTORY_SEPARATOR.'ContainerDdcWFZs');
