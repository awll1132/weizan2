<?php
/*
 __________________________________________________
|  Encode by BajieTeam on we7                      |
|__________________________________________________|
*/
 class MD5SignUtil { function sign($content, $key) { try { goto Q6FQ1; Th0Bt: return strtoupper(md5($signStr)); goto QgjsF; GyE8i: throw new SDKRuntimeException("\347\255\xbe\345\220\215\345\206\205\xe5\256\271\xe4\270\x8d\350\203\275\xe4\270\272\347\xa9\272" . "\x3c\142\162\x3e"); goto bt9iA; HooLU: vz6Xq: goto alUyZ; alUyZ: if (!(null == $content)) { goto uaxGo; } goto GyE8i; z_QMs: $signStr = $content . "\46\153\x65\171\x3d" . $key; goto Th0Bt; hpzGO: throw new SDKRuntimeException("\xe5\xaf\x86\xe9\x92\245\xe4\270\215\xe8\203\275\xe4\270\272\xe7\xa9\xba\xef\xbc\x81" . "\74\x62\x72\x3e"); goto HooLU; Q6FQ1: if (!(null == $key)) { goto vz6Xq; } goto hpzGO; bt9iA: uaxGo: goto z_QMs; QgjsF: } catch (SDKRuntimeException $e) { die($e->errorMessage()); } } function verifySignature($content, $sign, $md5Key) { goto FIgpf; ZbacJ: $calculateSign = strtolower(md5($signStr)); goto vfitJ; FIgpf: $signStr = $content . "\x26\x6b\145\x79\x3d" . $md5Key; goto ZbacJ; qMFK7: return $calculateSign == $tenpaySign; goto vWEHd; vfitJ: $tenpaySign = strtolower($sign); goto qMFK7; vWEHd: } } ?>
