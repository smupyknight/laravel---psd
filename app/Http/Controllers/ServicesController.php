<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service;
use App\SupportRole;
use App\Keyword;
use App\Description;
use App\Category;
use App\ServiceCategory;
use App\Name;
use App\Prerequisite;
use App\Jobs\ScrapeService;
use App\Event;
use App\Evidence;

class ServicesController extends Controller
{

	public function getIndex()
	{
		$query = Service::query();

		$query->join('support_roles', 'services.id', 'support_roles.service_id');
		$query->where('support_roles.service_role', 'QGS Service owner');
		$query->where('support_roles.email', session('email'));
		$query->select('services.*', 'support_roles.email', 'support_roles.service_role');

		$services = $query->paginate(25);

		return view('pages.services-list')
			->with('services', $services);
	}

	public function getDetails($service_id)
	{
		$service = Service::findOrFail($service_id);

		return view('pages.services-details')
			->with('service', $service);
	}

	public function getDelivery($service_id)
	{
		$service = Service::findOrFail($service_id);

		return view('pages.services-delivery')
			->with('service', $service);
	}

	public function getRequirements($service_id)
	{
		$service = Service::findOrFail($service_id);

		return view('pages.services-requirements')
			->with('service', $service);
	}

	public function getEditOwner($service_id)
	{
		$service = Service::findOrFail($service_id);

		return view('modals.services-edit-owner')
			->with('service', $service);
	}

	public function postEditOwner(Request $request, $service_id)
	{
		$this->validate($request, [
			'name'  => 'required',
			'email' => 'required|email',
		]);

		$service = Service::findOrFail($service_id);

		if (SupportRole::where('service_id', $service->id)->exists()) {
			$support_role = SupportRole::where('service_id', $service->id)->first();
		} else {
			$support_role             = new SupportRole;
			$support_role->service_id = $service->id;
		}

		$support_role->service_role = 'QGS Service owner';
		$support_role->person_name  = $request->name;
		$support_role->email        = $request->email;

		$support_role->save();

		$support_role->invite();
	}

	public function getAddName($service_id)
	{
		$service  = Service::findOrFail($service_id);
		$contexts = Name::select('context')->distinct()->get();

		return view('modals.services-add-name')
			->with('service', $service)
			->with('contexts', $contexts);
	}

	public function postAddName(Request $request, $service_id)
	{
		$this->validate($request, [
			'name'    => 'required',
			'context' => 'required',
		]);

		$service = Service::findOrFail($service_id);

		$name = new Name;

		$name->service_id = $service->id;
		$name->name       = $request->name;
		$name->context    = $request->context;

		$name->save();
	}

	public function getEditName($name_id)
	{
		$name     = Name::findOrFail($name_id);
		$contexts = Name::select('context')->distinct()->get();

		return view('modals.services-edit-name')
			->with('name', $name)
			->with('contexts', $contexts);
	}

	public function postEditName(Request $request, $name_id)
	{
		$this->validate($request, [
			'name'    => 'required',
			'context' => 'required',
		]);

		$name = Name::findOrFail($name_id);

		$name->name    = $request->name;
		$name->context = $request->context;

		$name->save();
	}

	public function getDeleteName($name_id)
	{
		$name = Name::findOrFail($name_id);

		return view('modals.services-delete-name')
			->with('name', $name);
	}

	public function postDeleteName(Request $request, $name_id)
	{
		$name = Name::findOrFail($name_id);

		$name->delete();
	}

	public function getChangeUrl($service_id)
	{
		$service = Service::findOrFail($service_id);

		return view('modals.services-change-url')
			->with('service', $service);
	}

	public function postChangeUrl(Request $request, $service_id)
	{
		$this->validate($request, [
			'url' => 'required|url',
		]);

		$service = Service::findOrFail($service_id);

		$service->url = $request->url;

		$service->save();

		dispatch(new ScrapeService($service));
	}

	public function getAddCategory($service_id)
	{
		$service = Service::findOrFail($service_id);

		$types = Category::select('type')->distinct()->pluck('type');

		return view('modals.services-add-category')
			->with('service', $service)
			->with('types', $types);
	}

	public function postAddCategory(Request $request, $service_id)
	{
		$this->validate($request, [
			'name' => 'required',
			'type' => 'required',
		]);

		$service = Service::findOrfail($service_id);

		$category = new Category;

		$category->name = $request->name;
		$category->type = $request->type;

		$category->save();

		$service_category = new ServiceCategory;

		$service_category->service_id  = $service->id;
		$service_category->category_id = $category->id;

		$service_category->save();
	}

	public function getDeleteCategory($service_category_id)
	{
		$service_category = ServiceCategory::findOrFail($service_category_id);

		return view('modals.services-delete-category')
			->with('service_category', $service_category);
	}

	public function postDeleteCategory(Request $request, $service_category_id)
	{
		$service_category = ServiceCategory::findOrFail($service_category_id);

		$service_category->category->delete();
		$service_category->delete();
	}

	public function getAddKeyword($service_id)
	{
		$service = Service::findOrFail($service_id);

		return view('modals.services-add-keyword')
			->with('service', $service);
	}

	public function postAddKeyword(Request $request, $service_id)
	{
		$this->validate($request, [
			'word' => 'required',
		]);

		$keyword = new Keyword;

		$keyword->service_id = $service_id;
		$keyword->word       = $request->word;

		$keyword->save();
	}

	public function getDeleteKeyword($keyword_id)
	{
		$keyword = Keyword::findOrFail($keyword_id);

		return view('modals.services-delete-keyword')
			->with('keyword', $keyword);
	}

	public function postDeleteKeyword(Request $request, $keyword_id)
	{
		$keyword = Keyword::findOrFail($keyword_id);

		$keyword->delete();
	}

	public function getEditKeyword($keyword_id)
	{
		$keyword = Keyword::findOrFail($keyword_id);

		return view('modals.services-edit-keyword')
			->with('keyword', $keyword);
	}

	public function postEditKeyword(Request $request, $keyword_id)
	{
		$keyword = Keyword::findOrFail($keyword_id);

		$this->validate($request, [
			'word' => 'required',
		]);

		$keyword->word = $request->word;

		$keyword->save();
	}

	public function getEditDescription($description_id)
	{
		$description = Description::findOrFail($description_id);

		$contexts = Description::select('context')->distinct()->pluck('context');

		return view('modals.services-edit-description')
			->with('description', $description)
			->with('contexts', $contexts);
	}

	public function postEditDescription(Request $request, $description_id)
	{
		$description = Description::findOrFail($description_id);

		$this->validate($request, [
			'description' => 'required',
			'context'     => 'required',
		]);

		$description->description = $request->description;
		$description->context     = $request->context;

		$description->save();
	}

	public function getDeleteDescription($description_id)
	{
		$description = Description::findOrFail($description_id);

		return view('modals.services-delete-description')
			->with('description', $description);
	}

	public function postDeleteDescription(Request $request, $description_id)
	{
		$description = Description::findOrFail($description_id);

		$description->delete();
	}

	public function getAddDescription($service_id)
	{
		$service = Service::findOrFail($service_id);

		return view('modals.services-add-description')
			->with('service', $service);
	}

	public function postAddDescription(Request $request, $service_id)
	{
		$this->validate($request, [
			'description' => 'required',
			'context'     => 'required',
		]);

		$description = new Description;

		$description->service_id  = $service_id;
		$description->description = $request->description;
		$description->context     = $request->context;

		$description->save();
	}

	public function getEditDetails($service_id)
	{
		$service = Service::findOrFail($service_id);

		return view('modals.services-edit-details')
			->with('service', $service);
	}

	public function postEditDetails(Request $request, $service_id)
	{
		$this->validate($request, [
			'qgs_id'         => 'required',
			'interaction_id' => 'required',
			'group_id'       => 'required',
		]);

		$service = Service::findOrFail($service_id);

		$service->qgs_service_id = $request->qgs_id;
		$service->interaction_id = $request->interaction_id;
		$service->group_id       = $request->group_id;

		$service->save();
	}

	public function getEditEligibility($service_id)
	{
		$service = Service::findOrFail($service_id);

		return view('modals.services-edit-eligibility')
			->with('service', $service);
	}

	public function postEditEligibility(Request $request, $service_id)
	{
		$this->validate($request, [
			'eligibility' => 'required',
		]);

		$service = Service::findOrFail($service_id);

		$service->eligibility = $request->eligibility;

		$service->save();
	}

	public function getAddPrerequisite($service_id)
	{
		$service = Service::findOrFail($service_id);

		return view('modals.services-add-prerequisite')
			->with('service', $service);
	}

	public function postAddPrerequisite(Request $request, $service_id)
	{
		$this->validate($request, [
			'content' => 'required',
		]);

		$service = Service::findOrFail($service_id);

		$prerequisite = new Prerequisite;

		$prerequisite->content    = $request->content;
		$prerequisite->service_id = $service->id;

		$prerequisite->save();
	}

	public function getDeletePrerequisite($prerequisite_id)
	{
		$prerequisite = Prerequisite::findOrFail($prerequisite_id);

		return view('modals.services-delete-prerequisite')
			->with('prerequisite', $prerequisite);
	}

	public function postDeletePrerequisite(Request $request, $prerequisite_id)
	{
		$prerequisite = Prerequisite::findOrFail($prerequisite_id);

		$prerequisite->delete();
	}

	public function getChangeParentService($service_id)
	{
		$service = Service::findOrFail($service_id);

		$services = Service::all();

		return view('modals.services-change-parent-service')
			->with('service', $service)
			->with('services', $services);
	}

	public function postChangeParentService(Request $request, $service_id)
	{
		$this->validate($request, [
			'content' => 'required',
		]);

		$service = Service::findOrFail($service_id);

		$prerequisite = new Prerequisite;

		$prerequisite->content    = $request->content;
		$prerequisite->service_id = $service->id;

		$prerequisite->save();
	}

	public function getAddEvent($service_id)
	{
		$service = Service::findOrFail($service_id);

		return view('modals.services-add-event')
			->with('service', $service);
	}

	public function postAddEvent(Request $request, $service_id)
	{
		$this->validate($request, [
			'name'     => 'required',
			'sequence' => 'required|numeric',
			'cost'     => 'required|numeric',
		]);

		$service = Service::findOrFail($service_id);

		$event = new Event;

		$event->service_id = $service->id;
		$event->name       = $request->name;
		$event->sequence   = $request->sequence;
		$event->cost       = $request->cost;

		$event->save();
	}

	public function getEditEvent($event_id)
	{
		$event = Event::findOrFail($event_id);

		return view('modals.services-edit-event')
			->with('event', $event);
	}

	public function postEditEvent(Request $request, $event_id)
	{
		$event = Event::findOrFail($event_id);

		$this->validate($request, [
			'name'     => 'required',
			'sequence' => 'required|numeric',
			'cost'     => 'required|numeric',
		]);

		$event->name     = $request->name;
		$event->sequence = $request->sequence;
		$event->cost     = $request->cost;

		$event->save();
	}

	public function getDeleteEvent($event_id)
	{
		$event = Event::findOrFail($event_id);

		return view('modals.services-delete-event')
			->with('event', $event);
	}

	public function postDeleteEvent(Request $request, $event_id)
	{
		$event = Event::findOrFail($event_id);

		$event->delete();
	}

	public function getAddEvidence($service_id)
	{
		$service = Service::findOrFail($service_id);

		return view('modals.services-add-evidence')
			->with('service', $service);
	}

	public function postAddEvidence(Request $request, $service_id)
	{
		$this->validate($request, [
			'name'          => 'required',
			'displayed_for' => 'required',
		]);

		$service = Service::findOrFail($service_id);

		$evidence = new Evidence;

		$evidence->service_id    = $service->id;
		$evidence->name          = $request->name;
		$evidence->displayed_for = $request->displayed_for;
		$evidence->meta_data     = (string) $request->meta_data;

		$evidence->save();
	}

	public function getEditEvidence($evidence_id)
	{
		$evidence = Evidence::findOrFail($evidence_id);

		return view('modals.services-edit-evidence')
			->with('evidence', $evidence);
	}

	public function postEditEvidence(Request $request, $evidence_id)
	{
		$evidence = Evidence::findOrFail($evidence_id);

		$this->validate($request, [
			'name'          => 'required',
			'displayed_for' => 'required',
		]);

		$evidence->name          = $request->name;
		$evidence->displayed_for = $request->displayed_for;
		$evidence->meta_data     = (string) $request->meta_data;

		$evidence->save();
	}

	public function getDeleteEvidence($evidence_id)
	{
		$evidence = Evidence::findOrFail($evidence_id);

		return view('modals.services-delete-evidence')
			->with('evidence', $evidence);
	}

	public function postDeleteEvidence(Request $request, $evidence_id)
	{
		$evidence = Evidence::findOrFail($evidence_id);

		$evidence->delete();
	}

}
