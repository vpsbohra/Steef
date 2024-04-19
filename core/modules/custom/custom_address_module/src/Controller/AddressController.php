<?php
namespace Drupal\custom_address_module\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\node\NodeInterface;

class AddressController extends ControllerBase
{

  public function getDropdownOptions()
  {
    try {
      $options = [];

      // Fetch the first 10 distinct city values.
      $queryCity = \Drupal::database()->select('bag_data', 'a');
      $queryCity->fields('a', ['city']);
      $queryCity->distinct();
      // $queryCity->range(0, 9);
      $cities = $queryCity->execute()->fetchCol();

      // Fetch the first 10 distinct postal code values.
      $queryPostalCode = \Drupal::database()->select('bag_data', 'a');
      $queryPostalCode->fields('a', ['postal_code']);
      $queryPostalCode->distinct();
      $queryPostalCode->range(0, 9);
      $postalCodes = $queryPostalCode->execute()->fetchCol();

      // Fetch the first 10 distinct street values.
      $queryStreet = \Drupal::database()->select('bag_data', 'a');
      $queryStreet->fields('a', ['street']);
      $queryStreet->distinct();
      $queryStreet->range(0, 9);
      $streets = $queryStreet->execute()->fetchCol();

      // Fetch the first 10 distinct number values.
      $queryNumber = \Drupal::database()->select('bag_data', 'a');
      $queryNumber->fields('a', ['number']);
      $queryNumber->distinct();
      $queryNumber->range(0, 9);
      $numbers = $queryNumber->execute()->fetchCol();

      // Fetch the first 10 distinct addition values.
      // $queryAddition = \Drupal::database()->select('bag_data', 'a');
      // $queryAddition->fields('a', ['addition']);
      // $queryAddition->distinct();
      // $queryAddition->range(0, 9);
      // $additions = $queryAddition->execute()->fetchCol();

      // Prepare the data array with first 10 distinct values for each column.
      $data = [
        'city' => array_values(array_unique($cities)),
        'postal_code' => array_values(array_unique($postalCodes)),
        'street' => array_values(array_unique($streets)),
        'number' => array_values(array_unique($numbers)),
        // 'addition' => array_values(array_unique($additions)),
      ];

      // Return options as JSON response.
      return new JsonResponse($data);
    } catch (\Exception $e) {
      // Log or handle the exception appropriately.
      \Drupal::logger('custom_address_module')->error('An error occurred while fetching dropdown options: @message', ['@message' => $e->getMessage()]);

      // Return an error response.
      return new JsonResponse(['error' => 'An error occurred. Please try again later.'], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
    }
  }


  public function getDropdownOptionsByCityName($city)
  {
    try {
      $options = [];

      // Fetch unique postal codes for the specified city.
      $queryPostalCodes = \Drupal::database()->select('bag_data', 'a');
      $queryPostalCodes->fields('a', ['postal_code']);
      $queryPostalCodes->distinct();
      $queryPostalCodes->condition('a.city', $city);
      $postalCodes = $queryPostalCodes->execute()->fetchCol();

      // Fetch unique streets for the specified city.
      $queryStreets = \Drupal::database()->select('bag_data', 'a');
      $queryStreets->fields('a', ['street']);
      $queryStreets->distinct();
      $queryStreets->condition('a.city', $city);
      $streets = $queryStreets->execute()->fetchCol();

      // Fetch unique numbers for the specified city.
      $queryNumbers = \Drupal::database()->select('bag_data', 'a');
      $queryNumbers->fields('a', ['number']);
      $queryNumbers->distinct();
      $queryNumbers->condition('a.city', $city);
      $numbers = $queryNumbers->execute()->fetchCol();

      // Fetch unique additions for the specified city.
      // $queryAdditions = \Drupal::database()->select('bag_data', 'a');
      // $queryAdditions->fields('a', ['addition']);
      // $queryAdditions->distinct();
      // $queryAdditions->condition('a.city', $city);
      // $additions = $queryAdditions->execute()->fetchCol();

      // Prepare the data array with unique values for each field.
      $data = [
        'postal_codes' => array_values(array_unique($postalCodes)),
        'streets' => array_values(array_unique($streets)),
        'numbers' => array_values(array_unique($numbers)),
        // 'additions' => array_values(array_unique($additions)),
      ];

      // Return data as JSON response.
      return new JsonResponse($data);
    } catch (\Exception $e) {
      // Log or handle the exception appropriately.
      \Drupal::logger('custom_address_module')->error('An error occurred while fetching unique values: @message', ['@message' => $e->getMessage()]);

      // Return an error response.
      return new JsonResponse(['error' => 'An error occurred. Please try again later.'], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
    }
  }


  public function getDropdownOptionsByPostalCode($postalCode)
{
    try {
        $options = [];

        // Fetch unique cities for the specified postal code.
        $queryCities = \Drupal::database()->select('bag_data', 'a');
        $queryCities->fields('a', ['city']);
        $queryCities->distinct();
        $queryCities->condition('a.postal_code', $postalCode);
        $cities = $queryCities->execute()->fetchCol();

        // Fetch unique streets for the specified postal code.
        $queryStreets = \Drupal::database()->select('bag_data', 'a');
        $queryStreets->fields('a', ['street']);
        $queryStreets->distinct();
        $queryStreets->condition('a.postal_code', $postalCode);
        $streets = $queryStreets->execute()->fetchCol();

        // Fetch unique numbers for the specified postal code.
        $queryNumbers = \Drupal::database()->select('bag_data', 'a');
        $queryNumbers->fields('a', ['number']);
        $queryNumbers->distinct();
        $queryNumbers->condition('a.postal_code', $postalCode);
        $numbers = $queryNumbers->execute()->fetchCol();

        // Fetch unique additions for the specified postal code.
        // $queryAdditions = \Drupal::database()->select('bag_data', 'a');
        // $queryAdditions->fields('a', ['addition']);
        // $queryAdditions->distinct();
        // $queryAdditions->condition('a.postal_code', $postalCode);
        // $additions = $queryAdditions->execute()->fetchCol();

        // Prepare the data array with unique values for each field.
        $data = [
            'cities' => array_values(array_unique($cities)),
            'streets' => array_values(array_unique($streets)),
            'numbers' => array_values(array_unique($numbers)),
            // 'additions' => array_values(array_unique($additions)),
        ];

        // Return data as JSON response.
        return new JsonResponse($data);
    } catch (\Exception $e) {
        // Log or handle the exception appropriately.
        \Drupal::logger('custom_address_module')->error('An error occurred while fetching unique values: @message', ['@message' => $e->getMessage()]);

        // Return an error response.
        return new JsonResponse(['error' => 'An error occurred. Please try again later.'], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
    }
}

  public function getUniqueValuesByCityAndPostalCode( $city, $postal_code)
  {


    try {
      $options = [];

      // Fetch rows where both city and postal code match the query.
      $query = \Drupal::database()->select('bag_data', 'a');
      $query->fields('a', ['street', 'number', 'postal_code', 'city']);
      $query->distinct();
      $query->condition('a.city', $city);
      $query->condition('a.postal_code', $postal_code);
      $rows = $query->execute()->fetchAll();

      // Prepare the data array with unique values for other columns.
      $uniqueValues = [];
      foreach ($rows as $row) {
        $uniqueValues['city'] = $row->city;
        $uniqueValues['postal_code'] = $row->postal_code;
        $uniqueValues['streets'][] = $row->street;
        $uniqueValues['numbers'][] = $row->number;
        // $uniqueValues['additions'][] = $row->addition;
      }

      // Remove duplicates from streets, numbers, and additions.
      $uniqueValues['streets'] = array_values(array_unique($uniqueValues['streets']));
      $uniqueValues['numbers'] = array_values(array_unique($uniqueValues['numbers']));
      // $uniqueValues['additions'] = array_values(array_unique($uniqueValues['additions']));

      // Return data as JSON response.
      return new JsonResponse($uniqueValues);
    } catch (\Exception $e) {
      // Log or handle the exception appropriately.
      \Drupal::logger('custom_address_module')->error('An error occurred while fetching unique values: @message', ['@message' => $e->getMessage()]);

      // Return an error response.
      return new JsonResponse(['error' => 'An error occurred. Please try again later.'], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
    }
  }


}
