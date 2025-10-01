
<?php

if (!function_exists('validate_cpf')) {
    /**

     * @param string
     * @return bool
     */
    function validate_cpf(string $cpf): bool
    {
        
        $cpf = preg_replace('/[^0-9]/', '', (string)$cpf);

        
        if (strlen($cpf) != 11) {
            return false;
        }

       
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }

        return true;
    }
}

if (!function_exists('format_currency_br')) {
    function format_currency_br($value): string
    {
        return 'R$ ' . number_format($value, 2, ',', '.');
    }
}