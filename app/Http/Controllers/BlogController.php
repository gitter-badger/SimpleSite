<?php

namespace App\Http\Controllers;

use App\Filters\NewsFilters;
use App\Http\Forms\StorePostForm;
use App\Http\Forms\UpdatePostForm;
use App\PhotoCategory;
use App\Post;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Jsvrcek\ICS\CalendarExport;
use Jsvrcek\ICS\CalendarStream;
use Jsvrcek\ICS\Model\Calendar;
use Jsvrcek\ICS\Model\CalendarEvent;
use Jsvrcek\ICS\Model\Relationship\Attendee;
use Jsvrcek\ICS\Model\Relationship\Organizer;
use Jsvrcek\ICS\Utility\Formatter;

class BlogController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param NewsFilters $filters
     *
     * @return \Illuminate\Http\Response
     */
    public function index(NewsFilters $filters)
    {
        return view('blog.index', [
            'posts' => Post::filter($filters)->with('members')->latest()->paginate(5)
        ]);
    }

    public function events()
    {
        $calendar = new Calendar(config('app.url'));
        $calendar->addCustomHeader('X-WR-CALNAME', trans('core.title.portal_calendar'));

        /** @var Post[] $events */
        $events = Post::events()->with('members')->latest()->get();

        foreach ($events as $event) {
            $calendarEvent = new CalendarEvent();
            $calendarEvent
                ->setStart($event->event_at)
                ->setSummary($event->title)
                ->setDescription(strip_tags($event->text_intro.PHP_EOL.$event->text).PHP_EOL.trans('core.post.label.link_to_event', [
                    'link' => $event->link
                ]))
                ->setUid('event_'.$event->id)
                ->setUrl($event->link);

            $organizer = new Organizer(new Formatter());
            $organizer->setValue($event->author->email);
            $organizer->setName($event->author->display_name);
            $calendarEvent->setOrganizer($organizer);

            foreach ($event->members as $member) {
                $attendee = new Attendee(new Formatter());
                $attendee->setValue($member->email)->setName($member->display_name);
                $calendarEvent->addAttendee($attendee);
            }

            $calendar->addEvent($calendarEvent);
        }

        //setup exporter
        $calendarExport = new CalendarExport(new CalendarStream, new Formatter());
        $calendarExport->addCalendar($calendar);

        $response = new Response($calendarExport->getStream());

        return $response;
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::findOrFail($id);

        return view('blog.show', [
            'post'       => $post,
            'categories' => $post->photo_categories()->notEmpty()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StorePostForm $form
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostForm $form)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);

        return view('blog.edit', [
            'post'                => $post,
            'categories'          => PhotoCategory::pluck('title', 'id')->all(),
            'selected_categories' => $post->photo_categories->pluck('id')->all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdatePostForm $form
     * @param  int            $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostForm $form, $id)
    {
        $form->isValid();

        $post = Post::findOrFail($id);

        $post->update($form->fields());
        $post->photo_categories()->sync((array) $form->photo_categories);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return back();
    }

    /**
     * @param Request $request
     * @param int     $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addMember(Request $request, $id)
    {
        /** @var Post $post */
        $post = Post::findOrFail($id);

        if (! $post->hasMember($user = $request->user())) {
            $post->addMember($user);
        }

        return back();
    }
}
