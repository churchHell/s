<?php

\Illuminate\Database\Eloquent\Builder::mixin(new \App\Macroses\BuilderMixin());
\Illuminate\Translation\Translator::mixin(new \App\Macroses\LangMixin());
\Illuminate\View\ComponentAttributeBag::mixin(new \App\Macroses\ComponentAttributeBagMixin());
\Illuminate\Support\Stringable::mixin(new \App\Macroses\StringableMixin());