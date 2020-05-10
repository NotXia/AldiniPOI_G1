<?php

   /*
      Genera una sequenza alfanumerica casuale crittograficamente sicura
   */

   function token_gen(
   int $length = 128,
   string $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'): string {

      $pieces = [];
      $max = mb_strlen($keyspace, '8bit') - 1;
      for ($i = 0; $i < $length; ++$i) {
         $pieces [] = $keyspace[random_int(0, $max)];
      }
      return implode('', $pieces);
   }

 ?>
