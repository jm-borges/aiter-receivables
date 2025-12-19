<?php

namespace App\ApiClients\Nuclea;

use App\ApiClients\ApiClient;
use Illuminate\Support\Str;

class NucleaAuthApiClient extends ApiClient
{
    protected string $participantIdentifier;
    protected string $certificatePrivateKey;
    protected string $certificateFingerPrint;
    protected string $certificateSerialNumber;

    public function __construct()
    {
        $this->participantIdentifier = config('services.nuclea.participant.identifier');
        $this->certificatePrivateKey = config('services.nuclea.participant.certificate_private_key');
        $this->certificateFingerPrint = config('services.nuclea.participant.certificate_finger_print');
        $this->certificateSerialNumber = config('services.nuclea.participant.certificate_serial_number');
    }

    /**
     * Generates a JWS (JSON Web Signature) based on the provided payload.
     *
     * @param array $payload The payload to be signed.
     * @return string The signed JWS, including the JOSE header and the signature.
     */
    public function getJsonWebSignature(string $method, ?array $payload = null): string
    {
        $joseHeader = $this->getJoseHeader();
        $jsonEncodedJoseHeader = $this->jsonEncodeBase64Url($joseHeader);
        $jsonEncodedPayload = $method == 'post' || $method == 'put' || $method == 'patch' ? $this->jsonEncodeBase64Url($payload) : '';
        $signatureInput = $jsonEncodedJoseHeader . '.' . $jsonEncodedPayload;
        $base64UrlSignature = $this->generateSignature($signatureInput);
        $detachedJws = "$jsonEncodedJoseHeader..$base64UrlSignature";
        return $detachedJws;
    }

    /**
     * Encodes the given data to JSON in UTF-8 and then to Base64Url format.
     *
     * @param array|string $data The data to be encoded.
     * @return string The Base64Url encoded string.
     */
    private function jsonEncodeBase64Url(array|string $data): string
    {
        $json = json_encode($data);
        return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode(str_replace(['\\'], '', $json)));
    }

    private function generateSignature(string $input): string
    {
        $input = mb_convert_encoding($input, 'UTF-8');

        $privateKeyPem = trim($this->certificatePrivateKey);

        $privateKeyPem = str_replace("-----BEGIN PRIVATE KEY-----", "-----BEGIN PRIVATE KEY-----\n", $privateKeyPem);
        $privateKeyPem = str_replace("-----END PRIVATE KEY-----", "\n-----END PRIVATE KEY-----", $privateKeyPem);
        $privateKey = openssl_pkey_get_private($privateKeyPem);
        !openssl_sign($input, $signature, $privateKey, OPENSSL_ALGO_SHA256);

        $base64Signature =  str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

        return $base64Signature;
    }



    /**
     * Creates the JOSE header for the JWS.
     *
     * @return array The JOSE header as an associative array.
     */
    private function getJoseHeader(): array
    {
        return [
            "alg" => 'RS256',
            "x5t#S256" => $this->formatCertificateFingerprint($this->certificateFingerPrint),
            "kid" => $this->formatCertificateSerialNumber($this->certificateSerialNumber),
            "http://www.cip-bancos.org.br/identificador-requisicao" => (string) Str::uuid(),
            "http://www.cip-bancos.org.br/data-referencia" => date('Y-m-d'),
            "http://www.cip-bancos.org.br/identificador-emissor-principal" => $this->participantIdentifier,
            "http://www.cip-bancos.org.br/identificador-emissor-administrado" => $this->participantIdentifier,
        ];
    }

    /**
     * Formats the certificate fingerprint by removing colons and converting to Base64Url.
     *
     * @param string $fingerprint The certificate fingerprint in hexadecimal format.
     * @return string The Base64Url encoded fingerprint.
     */
    private function formatCertificateFingerprint(string $fingerprint): string
    {
        return $this->hextob64u(str_replace(":", "", $fingerprint));
    }

    /**
     * Converts a hexadecimal string to Base64Url format.
     *
     * @param string $hex The hexadecimal string to be converted.
     * @return string The Base64Url encoded string.
     */
    private function hextob64u(string $hex): string
    {
        $binary = hex2bin($hex);
        return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($binary));
    }

    /**
     * Formats the certificate serial number to ensure it has 32 characters,
     * padding with zeros on the left if necessary, and converts to uppercase.
     *
     * @param string $serialNumber The original serial number.
     * @return string The formatted serial number as a 32-character uppercase string.
     */
    private function formatCertificateSerialNumber(string $serialNumber): string
    {
        while (strlen($serialNumber) < 32) {
            $serialNumber = "0" . $serialNumber;
        }

        return strtoupper($serialNumber);
    }
}
