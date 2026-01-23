<?php

if (!function_exists('removeSpecialCharacters')) {
    function removeSpecialCharacters(string $string): string
    {
        return preg_replace('/[^a-zA-Z0-9]/', '', $string);
    }
}

if (!function_exists('decodeLlmJsonResponse')) {
    function decodeLlmJsonResponse(string $string): array
    {
        // Remove a marcação do código JSON
        if (preg_match('/```json\s*(.*?)\s*```/s', $string, $matches)) {
            $string = $matches[1];
        }

        // Limpa quebras de linha, espaços em excesso e outros caracteres
        $string = preg_replace('/\n|\r|\s+/', ' ', $string); // Remove quebras de linha e espaços extras

        // Decodifica o JSON
        $decoded = json_decode(trim($string), true);

        // Retorna o array decodificado ou um array vazio se falhar
        return is_array($decoded) ? $decoded : [];
    }
}

if (! function_exists('format_document')) {
    function format_document(?string $doc): string
    {
        if (! $doc) return '—';

        $doc = preg_replace('/\D/', '', $doc);

        if (strlen($doc) === 11) {
            // CPF
            return preg_replace('/^(\d{3})(\d{3})(\d{3})(\d{2})$/', '$1.$2.$3-$4', $doc);
        }

        if (strlen($doc) === 14) {
            // CNPJ
            return format_cnpj($doc);
        }

        return $doc;
    }
}

if (! function_exists('format_cnpj')) {
    function format_cnpj(?string $cnpj): string
    {
        if (! $cnpj) {
            return '—';
        }

        // remove tudo que não for número
        $cnpj = preg_replace('/\D/', '', $cnpj);

        if (strlen($cnpj) !== 14) {
            return $cnpj; // fallback defensivo
        }

        return preg_replace(
            '/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$/',
            '$1.$2.$3/$4-$5',
            $cnpj
        );
    }
}
