<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Service;
use App\Name;
use App\Description;
use App\Category;
use App\ServiceCategory;
use App\Event;
use App\Form;
use App\Evidence;
use App\RelatedService;
use App\VirtualDeliveryChannel;
use App\Location;
use App\SupportRole;
use App\Agency;
use App\AgencySupportRole;
use App\DeliveryOrganisation;
use App\VirtualDeliveryHour;
use App\LocationAddress;
use App\LocationPhoneNumber;
use App\LocationEmail;
use App\LocationHour;
use App\DeliveryChannel;
use App\Prerequisite;

class ImportData extends Command
{

	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'importdata';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Command description';

	/**
	 * Create a new command instance.gp
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
		$this->importServices();
		$this->importNames();
		$this->importDescriptions();
		$this->importEvents();
		$this->importCategories();
		$this->importServiceCategories();
		$this->importForms();
		$this->importEvidence();
		$this->importRelatedServices();
		$this->importVirtualDeliveryChannels();
		$this->importLocations();
		$this->importDeliveryChannels();
		$this->importSupportRoles();
		$this->importAgencies();
		$this->importAgencySupportRoles();
		$this->importDeliveryOrganisations();
		$this->importVirtualDeliveryHours();
		$this->importLocationAddresses();
		$this->importLocationPhoneNumbers();
		$this->importLocationEmails();
		$this->importLocationHours();
	}

	private function importServices()
	{
		$file = fopen(base_path().'/storage/app/csvs/service.csv', 'r');

		$this->info('Importing services...');

		$headers = ['Service ID','Interaction ID','Group ID','Group Header', 'QGS Service ID', 'Eligibility', 'Pre-requisites', 'Keywords', 'Fees', 'Reference URL' , 'Parent service', 'Status'];

		fgetcsv($file);

		while ($row = fgetcsv($file)) {
			$row = array_combine($headers, $row);

			$service = new Service;

			$service->id             = (int) $row['Service ID'];
			$service->interaction_id = $row['Interaction ID'];
			$service->group_id       = $row['Group ID'];
			$service->group_header   = (int) $row['Group Header'];
			$service->qgs_service_id = $row['QGS Service ID'];
			$service->eligibility    = utf8_encode($row['Eligibility']);
			$service->fees           = $row['Fees'];
			$service->url            = $row['Reference URL'];
			$service->status         = $row['Status'];

			$service->save();

			if ($row['Pre-requisites']) {
				$prerequisite = new Prerequisite;
				$prerequisite->service_id = $service->id;
				$prerequisite->content = utf8_encode($row['Pre-requisites']);
				$prerequisite->save();
			}
		}

		fclose($file);

		$file = fopen(base_path().'/storage/app/csvs/service.csv', 'r');

		fgetcsv($file);

		$this->info('Linking Parent Services...');

		while ($row = fgetcsv($file)) {
			$row = array_combine($headers, $row);

			$service = Service::findOrFail((int) $row['Service ID']);

			$service->parent_service_id = $row['Parent service'] ? (int) $row['Parent service'] : null;

			$service->save();
		}

		fclose($file);
	}

	private function importNames()
	{
		$file = fopen(base_path().'/storage/app/csvs/service_name.csv', 'r');

		$this->info('Importing names...');

		$headers = ['Service name ID', 'Service ID', 'Service name', 'Context'];

		fgetcsv($file);

		while ($row = fgetcsv($file)) {
			$row = array_combine($headers, $row);

			$name = new Name;

			$name->id         = $row['Service name ID'];
			$name->service_id = $row['Service ID'];
			$name->name       = utf8_encode($row['Service name']);
			$name->context    = $row['Context'];

			$name->save();
		}

		fclose($file);
	}

	private function importDescriptions()
	{
		$file = fopen(base_path().'/storage/app/csvs/service_description.csv', 'r');

		$this->info('Importing descriptions...');

		$headers = ['Service description ID', 'Service ID', 'Service description', 'Context'];

		fgetcsv($file);

		while ($row = fgetcsv($file)) {
			$row = array_combine($headers, $row);

			$description = new Description;

			$description->id = $row['Service description ID'];
			$description->service_id = $row['Service ID'];
			$description->description = utf8_encode($row['Service description']);
			$description->context = $row['Context'];

			$description->save();
		}

		fclose($file);
	}

	private function importEvents()
	{
		$file = fopen(base_path().'/storage/app/csvs/service_event.csv', 'r');

		$this->info('Importing events...');

		$headers = ['Service event ID', 'Service ID', 'Service event', 'Service event sequence'];

		fgetcsv($file);

		while ($row = fgetcsv($file)) {
			$row = array_combine($headers, $row);

			$event = new Event;

			$event->id = $row['Service event ID'];
			$event->service_id = $row['Service ID'];
			$event->name = $row['Service event'];
			$event->sequence = $row['Service event sequence'];

			$event->save();
		}

		fclose($file);
	}

	private function importCategories()
	{
		$file = fopen(base_path().'/storage/app/csvs/service_grouping.csv', 'r');

		$this->info('Importing categories...');

		$headers = ['Service grouping ID', 'Service ID', 'Category', 'Category type'];

		fgetcsv($file);

		while ($row = fgetcsv($file)) {
			$row = array_combine($headers, $row);

			if (!Category::whereName($row['Category'])->whereType($row['Category type'])->exists()) {
				$category = new Category;

				$category->name = $row['Category'];
				$category->type = $row['Category type'];

				$category->save();
			}
		}

		fclose($file);
	}

	private function importServiceCategories()
	{
		$file = fopen(base_path().'/storage/app/csvs/service_grouping.csv', 'r');

		$this->info('Importing service categories...');

		$headers = ['Service grouping ID', 'Service ID', 'Category', 'Category type'];

		fgetcsv($file);

		while ($row = fgetcsv($file)) {
			$row = array_combine($headers, $row);

			$service_category = new ServiceCategory;

			$service_category->id = $row['Service grouping ID'];
			$service_category->service_id = $row['Service ID'];
			$service_category->category_id = Category::whereName($row['Category'])->whereType($row['Category type'])->first()->id;

			$service_category->save();
		}

		fclose($file);
	}

	private function importForms()
	{
		$file = fopen(base_path().'/storage/app/csvs/service_delivery_form.csv', 'r');

		$this->info('Importing forms...');

		$headers = ['Service delivery form ID', 'Service ID', 'Form name', 'URL', 'Form source'];

		fgetcsv($file);

		while ($row = fgetcsv($file)) {
			$row = array_combine($headers, $row);

			$form = new Form;

			$form->id = $row['Service delivery form ID'];
			$form->service_id = $row['Service ID'];
			$form->name = $row['Form name'];
			$form->url = $row['URL'];
			$form->source = $row['Form source'];

			$form->save();
		}

		fclose($file);
	}

	private function importEvidence()
	{
		$file = fopen(base_path().'/storage/app/csvs/evidence.csv', 'r');

		$this->info('Importing evidence...');

		$headers = ['Evidence ID', 'Service ID', 'Evidence name', 'Displayed for', 'Metadata'];

		fgetcsv($file);

		while ($row = fgetcsv($file)) {
			$row = array_combine($headers, $row);

			$evidence = new Evidence;

			$evidence->id = $row['Evidence ID'];
			$evidence->service_id = $row['Service ID'];
			$evidence->name = $row['Evidence name'];
			$evidence->displayed_for = $row['Displayed for'];
			$evidence->meta_data = $row['Metadata'];

			$evidence->save();
		}

		fclose($file);
	}

	private function importRelatedServices()
	{
		$file = fopen(base_path().'/storage/app/csvs/service_relationship.csv', 'r');

		$this->info('Importing related services...');

		$headers = ['Service relationship ID', 'Service ID 1', 'Service ID 2', 'Relationship'];

		fgetcsv($file);

		while ($row = fgetcsv($file)) {
			$row = array_combine($headers, $row);

			$related_service = new RelatedService;

			$related_service->id = $row['Service relationship ID'];
			$related_service->service_id = $row['Service ID 1'];
			$related_service->related_service_id = $row['Service ID 2'];
			$related_service->relationship = $row['Relationship'];

			$related_service->save();
		}

		fclose($file);
	}

	private function importVirtualDeliveryChannels()
	{
		$file = fopen(base_path().'/storage/app/csvs/service_relationship.csv', 'r');

		$this->info('Importing virtual delivery channels...');

		$headers = ['Virtual delivery channel ID', 'Service delivery ID', 'Virtual delivery details', 'Additional details'];

		fgetcsv($file);

		while ($row = fgetcsv($file)) {
			$row = array_combine($headers, $row);

			$virtual_delivery_channel = new VirtualDeliveryChannel;

			$virtual_delivery_channel->id = $row['Virtual delivery channel ID'];
			$virtual_delivery_channel->details = $row['Virtual delivery details'];
			$virtual_delivery_channel->additional_details = $row['Additional details'];

			$virtual_delivery_channel->save();
		}

		fclose($file);
	}

	private function importLocations()
	{
		$file = fopen(base_path().'/storage/app/csvs/location.csv', 'r');

		$this->info('Importing locations...');

		$headers = ['Location ID', 'Location name', 'Location type', 'Agency', 'Accessibility/facilities', 'Additional information'];

		fgetcsv($file);

		while ($row = fgetcsv($file)) {
			$row = array_combine($headers, $row);

			$location = new Location;

			$location->id = $row['Location ID'];
			$location->name = utf8_encode($row['Location name']);
			$location->type = $row['Location type'];
			$location->agency = $row['Agency'];
			$location->accessibility_facilities = $row['Accessibility/facilities'];
			$location->additional_information = utf8_encode($row['Additional information']);

			$location->save();
		}

		fclose($file);
	}

	private function importDeliveryChannels()
	{
		$file = fopen(base_path().'/storage/app/csvs/service_delivery.csv', 'r');

		$this->info('Importing delivery locations...');

		$headers = ['Service Delivery ID', 'Service ID', 'Delivery Channel', 'Status'];

		fgetcsv($file);

		while ($row = fgetcsv($file)) {
			$row = array_combine($headers, $row);

			$status = null;

			if ($row['Status'] == 'Closed') {
				$status = 'Closed';
			}

			if ($row['Status'] == 'Open') {
				$status = 'Open';
			}

			$delivery_channel = new DeliveryChannel;

			$delivery_channel->id = $row['Service Delivery ID'];
			$delivery_channel->service_id = (int) $row['Service ID'];
			$delivery_channel->name = $row['Delivery Channel'];
			$delivery_channel->status = $status;

			$delivery_channel->save();
		}

		fclose($file);
	}

	private function importSupportRoles()
	{
		$file = fopen(base_path().'/storage/app/csvs/support_role.csv', 'r');

		$this->info('Importing support roles...');

		$headers = ['Support role ID', 'Service ID', 'Person name', 'Service role', 'Phone number', 'Email', 'Context'];

		fgetcsv($file);

		while ($row = fgetcsv($file)) {
			$row = array_combine($headers, $row);

			$support_role = new SupportRole;

			$support_role->id = $row['Support role ID'];
			$support_role->service_id = $row['Service ID'];
			$support_role->person_name = $row['Person name'];
			$support_role->service_role = $row['Service role'];
			$support_role->phone = $row['Phone number'];
			$support_role->email = $row['Email'];

			$support_role->save();
		}

		fclose($file);
	}

	private function importAgencies()
	{
		$file = fopen(base_path().'/storage/app/csvs/agency_details.csv', 'r');

		$this->info('Importing agencies...');

		$headers = ['Agency details ID', 'Agency', 'Agency name', 'Agency type', 'URL'];

		fgetcsv($file);

		while ($row = fgetcsv($file)) {
			$row = array_combine($headers, $row);

			$agency = new Agency;

			$agency->id = $row['Agency details ID'];
			$agency->code = $row['Agency'];
			$agency->name = $row['Agency name'];
			$agency->type = $row['Agency type'];
			$agency->url = $row['URL'];

			$agency->save();
		}

		fclose($file);
	}

	private function importAgencySupportRoles()
	{
		$file = fopen(base_path().'/storage/app/csvs/agency_support_role.csv', 'r');

		$this->info('Importing agency support roles...');

		$headers = ['Agency support role ID', 'Agency Code', 'Agency support role', 'Email', 'Context'];

		fgetcsv($file);

		while ($row = fgetcsv($file)) {
			$row = array_combine($headers, $row);

			$agency_support_role = new AgencySupportRole;

			$agency_support_role->id = $row['Agency support role ID'];
			$agency_support_role->code = $row['Agency Code'];
			$agency_support_role->name = $row['Agency support role'];
			$agency_support_role->email = $row['Email'];
			$agency_support_role->context = $row['Context'];

			$agency_support_role->save();
		}

		fclose($file);
	}

	private function importDeliveryOrganisations()
	{
		$file = fopen(base_path().'/storage/app/csvs/delivery_organisation.csv', 'r');

		$this->info('Importing delivery organistaions...');

		$headers = ['Delivery organisation ID', 'Service ID', 'Business unit name', 'Agency'];

		fgetcsv($file);

		while ($row = fgetcsv($file)) {
			$row = array_combine($headers, $row);

			$delivery_organisation = new DeliveryOrganisation;

			// $delivery_organisation->id = $row['Delivery organisation ID'];
			$delivery_organisation->service_id = $row['Service ID'];
			$delivery_organisation->business_unit_name = $row['Business unit name'];
			$delivery_organisation->code = $row['Agency'];

			$delivery_organisation->save();
		}

		fclose($file);
	}

	private function importVirtualDeliveryHours()
	{
		$file = fopen(base_path().'/storage/app/csvs/virtual_delivery_hours.csv', 'r');

		$this->info('Importing virtual delivery hours...');

		$headers = ['Virtual delivery hours ID', 'Virtual delivery channel ID', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun', 'Comments', 'Valid from', 'Valid to'];

		fgetcsv($file);

		while ($row = fgetcsv($file)) {
			$row = array_combine($headers, $row);

			$channel_id = null;

			if (VirtualDeliveryChannel::whereId((int) $row['Virtual delivery channel ID'])->exists()) {
				$channel_id = (int) $row['Virtual delivery channel ID'];
			}

			$virtual_delivery_hour = new VirtualDeliveryHour;

			$virtual_delivery_hour->id = $row['Virtual delivery hours ID'];
			$virtual_delivery_hour->virtual_delivery_channel_id = $channel_id;
			$virtual_delivery_hour->monday = $row['Mon'];
			$virtual_delivery_hour->tuesday = $row['Tue'];
			$virtual_delivery_hour->wednesday = $row['Wed'];
			$virtual_delivery_hour->thursday = $row['Thu'];
			$virtual_delivery_hour->friday = $row['Fri'];
			$virtual_delivery_hour->saturday = $row['Sat'];
			$virtual_delivery_hour->sunday = $row['Sun'];
			$virtual_delivery_hour->comments = utf8_encode($row['Comments']);

			$virtual_delivery_hour->save();
		}

		fclose($file);
	}

	private function importLocationAddresses()
	{
		$file = fopen(base_path().'/storage/app/csvs/location_address.csv', 'r');

		$this->info('Importing location addresses...');

		$headers = ['Location address ID', 'Location ID', 'Address type', 'Address 1', 'Address 2', 'Suburb', 'Postcode', 'Latitude', 'Longitude', 'Additional Information'];

		fgetcsv($file);

		while ($row = fgetcsv($file)) {
			$row = array_combine($headers, $row);

			$location_address = new LocationAddress;

			$location_address->id = $row['Location address ID'];
			$location_address->location_id = $row['Location ID'];
			$location_address->address_type = $row['Address type'];
			$location_address->address_one = $row['Address 1'];
			$location_address->address_two = $row['Address 2'];
			$location_address->suburb = $row['Suburb'];
			$location_address->postcode = $row['Postcode'];
			$location_address->latitude = $row['Latitude'];
			$location_address->longitude = $row['Longitude'];
			$location_address->additional_information = $row['Additional Information'];

			$location_address->save();
		}

		fclose($file);
	}

	private function importLocationPhoneNumbers()
	{
		$file = fopen(base_path().'/storage/app/csvs/location_phone_number.csv', 'r');

		$this->info('Importing phone numbers...');

		$headers = ['Location phone number ID', 'Location ID', 'Phone number', 'Comment'];

		fgetcsv($file);

		while ($row = fgetcsv($file)) {
			$row = array_combine($headers, $row);

			$location_phone_number = new LocationPhoneNumber;

			$location_phone_number->id = $row['Location phone number ID'];
			$location_phone_number->location_id = $row['Location ID'];
			$location_phone_number->phone_number = utf8_encode($row['Phone number']);
			$location_phone_number->comments = $row['Comment'];

			$location_phone_number->save();
		}

		fclose($file);
	}

	private function importLocationEmails()
	{
		$file = fopen(base_path().'/storage/app/csvs/location_email.csv', 'r');

		$this->info('Importing location emails...');

		$headers = ['Location email ID', 'Location ID', 'Email address', 'Comment'];

		fgetcsv($file);

		while ($row = fgetcsv($file)) {
			$row = array_combine($headers, $row);

			$location_email = new LocationEmail;

			$location_email->location_id = (int) $row['Location ID'];
			$location_email->email = $row['Email address'];
			$location_email->comments = $row['Comment'];

			$location_email->save();
		}

		fclose($file);
	}

	private function importLocationHours()
	{
		$file = fopen(base_path().'/storage/app/csvs/location_hours.csv', 'r');

		$this->info('Importing location hours...');

		$headers = ['Location hours ID', 'Location ID', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun', 'Comments', 'Valid from', 'Valid to'];

		fgetcsv($file);

		while ($row = fgetcsv($file)) {
			$row = array_combine($headers, $row);

			$location_hour = new LocationHour;

			$location_hour->location_id = $row['Location ID'];
			$location_hour->monday = $row['Mon'];
			$location_hour->tuesday = $row['Tue'];
			$location_hour->wednesday = $row['Wed'];
			$location_hour->thursday = $row['Thu'];
			$location_hour->friday = $row['Fri'];
			$location_hour->saturday = $row['Sat'];
			$location_hour->sunday = $row['Sun'];
			$location_hour->comments = $row['Comments'];
			$location_hour->valid_to = $row['Valid to'];
			$location_hour->valid_from = $row['Valid from'];

			$location_hour->save();
		}

		fclose($file);
	}

}