<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\Helpers\ValueObjects;

use LaravelCoreModule\CoreModuleMaker\Exceptions\InvalidArgumentException;


/**
 * Class ***`PhoneNumber`***
 *
 * The PhoneNumber class represents a phone number value object.
 *
 * The `PhoneNumber` class represents a `phone number` as a value object.
 * It encapsulates the `country code`, `area code`, `phone number` and `type` itself.
 *
 * Usage:
 * To create a `PhoneNumber` object, pass an array with the keys `country_code`,
 * `area_code`, `number` and `type`,  to the constructor. The associated values
 * should be strings.
 *
 * Example:
 * ```
 * $phoneNumber = new PhoneNumber([
 *     'country_code' => '1',
 *     'area_code' => '123',
 *     'number' => '4567890',
 *     'type' => 'mobile',
 * ]);
 * ```
 *
 * The `PhoneNumber` class provides various methods for working with phone numbers,
 * such as retrieving the `country code`, `area code`, and `phone number`, validating
 * the phone number's format, and converting the object to a string or an array.
 *
 * @package ***`LaravelCoreModule\CoreModuleMaker\Helpers\ValueObjects`***
 */
class PhoneNumber
{
    /**
     * The country code of the phone number.
     *
     * @var int
     */
    private int $country_code;

    /**
     * The area code of the phone number.
     *
     * @var int|null
     */
    private ?int $area_code;

    /**
     * The number.
     *
     * @var int
     */
    private int $number;

    /**
     * The number.
     *
     * @var string|null
     */
    private ?string $type;


    /**
     * Create a new instance of PhoneNumber.
     *
     * @param array $attributes The attributes of the phone number.
     *                          The array should contain the keys 'country_code', 'area_code', and 'number'.
     *                          The associated values should be strings.
     */
    public function __construct(array $attributes = [])
    {
        $this->validate($attributes);
        $this->setProperties(...$attributes);
        
    }

    public function setProperties(int $number, ?int $country_code, ?string $area_code, ?string $type): void
    {
        $this->setNumber($number);
        $this->setCountryCode($country_code);
        $this->setAreaCode($area_code);
        $this->setType($type);
    }

    /**
     * Get the country code of the phone number.
     *
     * @return int The country code.
     */
    public function getCountryCode(): int
    {
        return $this->country_code;
    }

    /**
     * Get the area code of the phone number.
     *
     * @return int|null The area code.
     */
    public function getAreaCode(): ?int
    {
        return $this->area_code;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    private function setCountryCode(int $country_code): void
    {
        // You can add validation logic for country codes here
        $this->country_code = $country_code;
    }

    private function setAreaCode(?int $area_code): void
    {
        // You can add validation logic for extensions here if needed
        $this->area_code = $area_code;
    }

    private function setType(?string $type): void
    {
        // You can add validation logic for phone types here if needed
        $this->type = $type;
    }

    private function setNumber($number): void
    {
        // You can add validation logic for phone numbers here
        // For simplicity, we assume that the number should be numeric with no spaces or special characters
        if (!is_numeric($number) || strpos($number, ' ') !== false || preg_match('/[^0-9]/', $number)) {
            throw new \InvalidArgumentException('Invalid phone number format.');
        }

        // Remove any non-numeric characters from the phone number
        $this->number = $this->normalizePhoneNumber($number);
    }

    /**
     * Get the properties of the DTO.
     *
     * @return array The DTO properties.
     */
    protected function getProperties(): array
    {
        return get_object_vars($this);
    }

    public function getRawNumber(): int
    {
        // Return the raw phone number without any formatting
        return $this->number;
    }

    public function equals(PhoneNumber $other): bool
    {
        return $this->country_code === $other->country_code && $this->number === $other->number;
    }

    public function format(string $format = 'E.164'): string
    {
        // You can implement different formatting options here
        switch ($format) {
            case 'E.164':
                $formattedNumber = '+' . $this->country_code . $this->number;
                break;
            case 'National':
                // Implement national formatting here
                $formattedNumber = $this->number;
                break;
            default:
                $formattedNumber = $this->number;
        }

        return $formattedNumber;
    }

    /**
     * Convert the PhoneNumber object to a string representation.
     *
     * This method formats the phone number as a string, including the country code,
     * area code, and subscriber number.
     *
     * @return string The formatted phone number string.
     */
    public function toString()
    {
        // Format the phone number as needed
        return $this->formatCountryCode($this->country_code) . $this->formatAreaCode($this->area_code) . $this->getFormattedNumber($this->number);

        return $this->format();
    }

    /**
     * Convert the PhoneNumber object to a string representation.
     *
     * This method formats the phone number as a string, including the country code,
     * area code, and subscriber number.
     *
     * @return string The formatted phone number string.
     */
    public function __toString()
    {
        // Format the phone number as needed
        return $this->formatCountryCode($this->country_code) . $this->formatAreaCode($this->area_code) . $this->getFormattedNumber($this->number);
    }

    /**
     * Convert the PhoneNumber object to a JSON representation.
     *
     * This method converts the PhoneNumber object to a JSON string representation.
     *
     * @return string The JSON representation of the PhoneNumber object.
     */
    public function toJson(): string
    {
        // Format the phone number as needed
        return json_encode($this->toArray());
    }

    /**
    * Create a PhoneNumber object from a JSON representation.
    *
    * This static method creates a PhoneNumber object from a string representation
    * of a phone number. It performs normalization on the provided phone number
    * by removing non-digit characters and extracting the country code, area code,
    * and remaining digits. The resulting PhoneNumber object is returned.
    *
    * @param  string $json The JSON representation of the phone number.
    * @return self         The PhoneNumber object created from the JSON representation.

    * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\InvalidArgumentException If the JSON is invalid or does not represent a valid phone number.
    */
    public static function fromJson(string $json): self
    {
        $data = json_decode($json, true);

        if ($data === null || json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidArgumentException('Invalid JSON provided.');
        }

        return new self($data);
    }

    /**
     * Convert the PhoneNumber object to an array representation.
     *
     * This method converts the PhoneNumber object to an array representation,
     * including the country code, area code, and phone number.
     *
     * @return array The array representation of the PhoneNumber object.
     */
    public function toArray(): array
    {
        // Format thephone number as needed
        return [
            "country_code"  => $this->country_code,
            "area_code"     => $this->area_code,
            "number"        => $this->number,
            "type"          => $this->type,
        ];
    }

    /**
     * Validate the attributes of the PhoneNumber object.
     * This method performs validation on the provided data to ensure that all required keys are present and match the expected properties of the PhoneNumber object. If validation fails, a ValidationException is thrown.
     *
     * @param array $data The data to validate.
     * @return bool
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validate(array $data): bool
    {
        return $this->validatePhoneNumber($data['number']) && $this->validateCountryCode($data['country_code']) && $this->validateAreaCode($data['area_code']);
    }

    /**
     * Create a PhoneNumber object from a string representation.
     *
     * This static method creates a PhoneNumber object from a string representation
     * of a phone number. It performs normalization on the provided phone number
     * by removing non-digit characters and extracting the country code, area code,
     * and remaining digits. The resulting PhoneNumber object is returned.
     *
     * @param  string $number            The string representation of the phone number.
     * @return self                      The PhoneNumber object.
     *
     * @throws \InvalidArgumentException If an invalid phone number string is provided.
     */
    public static function fromString(string $phone_number): self
    {

        static::validateStringPhoneNumber($phone_number);

        // Extract the country code
        $country_code = static::extractCountryCode($phone_number );

        // Extract the area code
        $area_code = static::extractAreaCode($phone_number );

        // No parentheses, Extract the subscriber number
        $subscriber_number = static::extractSubscriberNumber($phone_number, (string) $country_code, (string) $area_code);

        return new self([
            "country_code"  => $country_code,
            "area_code"     => $area_code,
            "number"        => $subscriber_number
        ]);
    }

    /**
     * Normalize a phone number by removing non-digit characters.
     *
     * This method takes a phone number as input and removes any non-digit characters,
     * leaving only the numeric digits. This normalization step ensures that the phone number
     * is formatted consistently and can be used for validation or further processing.
     *
     * @param  mixed $number The phone number to normalize.
     * @return int           The normalized phone number.
     *
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\InvalidArgumentException If an invalid phone number is provided.
     */
    protected static function normalizePhoneNumber($number): int
    {
        // Normalize the phone number here (e.g., remove spaces, special characters, etc.)
        // For simplicity, we'll just remove any non-digit characters.
        if (is_string($number) || is_int($number)) {
            // Remove any non-digit characters from the phone number
            return (int) preg_replace('/[^0-9]/', '', (string) $number);
        } else {
            throw new InvalidArgumentException('Invalid phone number');
        }
    }

    /**
     * This function extracts the country code from the provided phone number string.
     * It uses a regular expression to match the country code pattern and returns the extracted country code as an integer.
     * If the country code cannot be extracted or the provided phone number does not match the expected format,
     * an `InvalidArgumentException` is thrown with the message 'Error while formatting phone number country code'.
     *
     * @param  string $phone_number The phone number string.
     * @return int                  The extracted country code as an integer.
     *
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\InvalidArgumentException If the country code cannot be extracted or the phone number does not match the expected format.
     */
    private static function extractCountryCode(string $phone_number): int
    {
        preg_match('/^\+(\d+)/', (string) $phone_number, $matches);

        if(count($matches)){
            if (isset($matches[1])) {
                // Extract the country code and remove non-digit characters
                return (int) preg_replace('/[^0-9]/', '', $matches[1]);
            }

            // Extract the country code from the first match and remove non-digit characters
            return (int) preg_replace('/[^0-9]/', '', $matches[0]);
        }

        // Throw an exception if the country code cannot be extracted or the phone number format is invalid
        throw new InvalidArgumentException('Error while formatting phone number country code');
    }

    /**
     * Extract the area code from the phone number.
     *
     * This method assumes that the area code is represented by the next set of digits
     * in the phone number.
     *
     * @param int $number The phone number.
     * @return int|null The extracted area code.
     */
    private static function extractAreaCode(string $phone_number): ?int
    {
        if (strpos($phone_number, '(') !== false && strpos($phone_number, ')') !== false) {

            preg_match('/\((\d+[\W\d]*)\)/', $phone_number, $matches);
            // preg_match('/\((\d+\D*)\)/', (string) $phone_number, $matches);
            // preg_match('/\((\d+)\W*\)/', (string) $phone_number, $matches);
            // preg_match('/\((\d+)\)/', (string) $phone_number, $matches);
            if(count($matches)){
                if (isset($matches[1])) {
                    return (int) preg_replace('/[^0-9]/', '', $matches[1]);
                }

                return (int) preg_replace('/[^0-9]/', '', $matches[0]);
            }
        }

        return null;
    }

    /**
     * Extract the subscriber number from the phone number.
     *
     * This method extracts the subscriber number from the phone number by removing
     * the country code and area code digits.
     *
     * @param  int $number       The phone number.
     * @param  int $country_code The country code.
     * @param  int $area_code    The area code.
     * @return int               The extracted subscriber number.
     */
    private static function extractSubscriberNumber(string $number, string $country_code, string $area_code = ''): int
    {
        // Remove the country code and area code from the phone number
        return (int) substr((string) static::normalizePhoneNumber($number), strlen($country_code . $area_code));
    }

    /**
     * Validate a string representation of a phone number.
     *
     * This method validates the provided phone number string against a specific pattern.
     * The pattern allows for various formats, including an optional country code, an optional area code enclosed in parentheses,
     * and a required 9-digit subscriber number. If the phone number does not match the expected format,
     * an `InvalidArgumentException` is thrown with the message 'Invalid phone number format'.
     *
     * @param string $phone_number The string representation of the phone number to validate.
     * @return void
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\InvalidArgumentException If the phone number does not match the expected format.
     */
    public static function validateStringPhoneNumber($phone_number)
    {
        // Define the regular expression pattern for phone number validation
        $pattern = '/^\+([1-9]\d{0,2})\s?(?:\((?!0{2,3}\))([1-9]\d{1,2})\)\s?)?(\d{8,11})$/';

        // Validate the phone number against the pattern
        if(!preg_match($pattern, $phone_number))
            throw new InvalidArgumentException('Invalid phone number format');
    }

    /**
     * Validate the phone number.
     *
     * @param  int $phoneNumber                          The phone number.
     * @return bool                                      True if the phone number is valid; otherwise, false.
     *
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\InvalidArgumentException If the phone number is empty or does not have a valid length.
     */
    private static function validatePhoneNumber(int $phoneNumber): bool
    {
        self::isNotEmpty((string) $phoneNumber, 'Phone number cannot be empty');

        // Validate the phone number: it must be a numeric string and have a length between 8 and 11 digits.
        if (!preg_match('/^\d{8,11}$/', (string) $phoneNumber)) {
            throw new InvalidArgumentException('Invalid phone number format.');
        }

        return true;
    }
    
    /**
     * Validate the country code.
     *
     * @param  int $countryCode                          The country code.
     * @return bool                                      True if the country code is valid; otherwise, false.
     *
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\InvalidArgumentException If the country code is empty, not a positive integer, or exceeds a 3-digit length.
     */
    private static function validateCountryCode(int $countryCode): bool
    {
        static::isNotEmpty((string) $countryCode, 'Country code cannot be empty');

        // Validate the country code: it must be a positive integer (not starting with 0) and have a length of 1 to 3 digits.
        if (!preg_match('/^[1-9]\d{0,2}$/', (string) $countryCode)) {
            throw new InvalidArgumentException('Invalid country code');
        }

        return true;
    }
    
    /**
     * Validate the area code.
     *
     * @param int|null $areaCode The area code to validate.
     * @return bool
     *
     * @throws \LaravelCoreModule\CoreModuleMaker\Exceptions\InvalidArgumentException If the area code is not a positive integer or exceeds a 3-digit length.
     */
    private static function validateAreaCode(?int $areaCode): bool
    {
        if ($areaCode === null) {
            return true;
        }

        // Convert area code to string for validation
        $areaCodeString = (string) $areaCode;

        // Area code must be a positive integer and should not exceed a 3-digit length.
        if (!preg_match('/^\d{2,3}$/', $areaCodeString)) {
            throw new InvalidArgumentException('Invalid area code');
        }

        return true;
    }

    /**
     * Check if a value is not empty.
     *
     * This function checks if the given value is not empty. If the value is empty,
     * it returns false; otherwise, it returns true.
     *
     * @param string $value The value to check.
     * @param string $message The error message to include in the exception.
     * @return bool Returns true if the value is not empty, false otherwise.
     */
    protected static function isNotEmpty(string $value, string $message): bool
    {
        if (empty($value)) {
            throw new \Exception($message);
        }
        return true;
    }

    /**
     * Get the formatted representation of the phone number.
     *
     * This method returns a formatted representation of the phone number,
     * where digits are separated by a specified splitter character.
     * By default, it adds dashes to separate digits into groups of three.
     *
     * @param  string $splitter The character used to separate digits. Default is '-'.
     * @return string           The formatted phone number.
     */
    public function getFormattedNumber(int $number, string $splitter = '-'): string
    {
        // Example formatting: Add dashes to separate digits into groups of three
        return implode($splitter, str_split((string) $number, 3));
    }

    /**
     * Format the country code with the plus symbol.
     *
     * @param string $country_code The country code.
     * @return string The formatted country code.
     */
    private function formatCountryCode(int $country_code): string
    {
        return "+" . (string) $country_code;
    }

    /**
     * Format the area code with parentheses.
     *
     * @param string|null $area_code The area code.
     * @return string The formatted area code.
     */
    private function formatAreaCode(?int $area_code): string
    {
        if ($area_code) {
            return " (" . $area_code . ") ";
        } else {
            return " ";
        }
    }
}