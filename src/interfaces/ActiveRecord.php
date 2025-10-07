<?php

interface ActiveRecord{
    public function salvar(): bool;
    public static function buscarPorId($id): self;
    public static function buscarTodos(): array;
}