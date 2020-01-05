<?php

namespace App\Http\Controllers;

use App\Relationship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\User;


class RelationshipController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $requests = DB::select("SELECT ru.id, rqs.name, rqs.profile_image_thumbnail_filename,
        os.name AS 'occupation', ru.requester_id, ru.responder_id, ru.relationship_id, r.requester_question FROM users AS u INNER JOIN relationships_users AS ru
        ON u.id = ru.responder_id INNER JOIN users AS rqs ON ru.requester_id = rqs.id INNER JOIN occupations AS os ON rqs.occupation_id = os.id
        INNER JOIN relationships AS r on ru.relationship_id = r.id WHERE u.id = ? AND ru.accepted = 0", [Auth::user()->id]);

        return view('dashboard.relationships.user_relationships', compact('requests'));
    }

    /**
     * Search for user to form a relationship.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function search(Request $request)
     {
        try {
          $username = $request->name;
          $user_id = Auth::user()->id;

          $users = DB::select("SELECT o.name AS 'occupation', u.name, u.id, ru.accepted, u.profile_image_thumbnail_filename FROM users AS u
          INNER JOIN occupations AS o ON o.id = u.occupation_id
          LEFT JOIN relationships_users AS ru ON (u.id = ru.requester_id OR u.id = ru.responder_id) AND (ru.responder_id = ? OR ru.requester_id = ?)
          WHERE u.name LIKE '{$username}%'", [$user_id, $user_id, $username]);

          $relationship_options = Relationship::all();

          $html = view('snippets.dashboard.relationships.user_search_result', compact('users', 'relationship_options'))->render();
          return response()->json(array('status' => 'success', 'html' => $html, 'users' => $users));
        } catch(Exception $e) {
          return response()->json(array('status' => 'error'));
        }

     }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
          $requester_id = Auth::user()->id;
          $responder_id = $request->responder_id;
          $relationship_id = 5;

          DB::insert('INSERT INTO relationships_users(requester_id, responder_id, relationship_id, accepted, created_at, updated_at) VALUES(?, ?, ?, ?, now(), now())', [$requester_id, $responder_id, $relationship_id, 0]);
          if($request->ajax()) {
            return response()->json(array('status'=>'success'));
          }
          return redirect()->back()->with('success', 'Successfully sent relationship request.');

        } catch(Exception $e) {
          if($request->ajax()) {
            return response()->json(array('status'=>'error'));
          }
          return redirect()->back()->with('error', 'Error sending relationship request, please try again later.');
        }
    }

    /**
     * Form relationship.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function accept_request(Request $request)
    {
      try {
        $relationship_id = $request->relationship_id;
        DB::update("UPDATE relationships_users SET accepted = 1 WHERE id = ?", [$relationship_id]);
        return response()->json(array('status' => 'success'));
      } catch(Exception $e) {
        return response()->json(array('status' => 'error'));
      }
    }

    /**
     * Destroy relationship.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function reject_request(Request $request)
    {
      try {
        $relationship_id = $request->relationship_id;
        DB::delete("DELETE FROM relationships_users WHERE id = ?", [$relationship_id]);
        return response()->json(array('status' => 'success'));
      } catch(Exception $e) {
        return response()->json(array('status' => 'error'));
      }
    }


    /**
     * Get all relationships for user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function get_relationships(Request $request)
    {
      try {
        // $relationships = DB::select("SELECT u.id, f.id AS 'friend_id', f.name, f.profile_image_thumbnail_filename, os.name AS 'occupation' FROM users AS u
        // INNER JOIN relationships_users AS ru ON u.id = ru.requester_id
        // OR u.id = ru.responder_id INNER JOIN users AS f ON ru.requester_id = f.id OR ru.responder_id = f.id
        // INNER JOIN occupations AS os ON f.occupation_id = os.id
        // WHERE u.id = ? AND ru.accepted = 1", [Auth::user()->id]);

        $first_table = DB::table('relationships_users')
        ->join('users', 'relationships_users.responder_id', '=', 'users.id')
        ->join('occupations', 'users.occupation_id', '=', 'occupations.id')
        ->select('users.id as friend_id', 'users.name', 'users.profile_image_thumbnail_filename', 'occupations.name as occupation')
        ->where([
          ['relationships_users.requester_id', '=', Auth::user()->id], ['relationships_users.accepted', '=', '1']
        ]);

        $relationships = DB::table('relationships_users')
        ->join('users', 'relationships_users.requester_id', '=', 'users.id')
        ->join('occupations', 'users.occupation_id', '=', 'occupations.id')
        ->select('users.id as friend_id', 'users.name', 'users.profile_image_thumbnail_filename', 'occupations.name as occupation')
        ->where([
          ['relationships_users.responder_id', '=', Auth::user()->id], ['relationships_users.accepted', '=', '1']
        ])
        ->unionAll($first_table)
        ->get();

        $html = view('snippets.dashboard.relationships.user_relationships_list', compact('relationships'))->render();

        return response()->json(array('status' => 'success', 'html' => $html));

      } catch(Exception $exception) {
        return response()->json(array('status' => 'success'));
      }
    }

    /**
     * Delete relationship.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete_relationship(Request $request)
    {
      if(is_null($request->user_id_to_delete)) {
        return response()->json(array('status' => 'error'));
      }
      try {
        $user_id_to_delete = $request->user_id_to_delete;
        DB::delete("DELETE FROM relationships_users WHERE (requester_id = ? AND responder_id = ?) OR (requester_id = ? AND responder_id = ?)",
        [$user_id_to_delete, Auth::user()->id, Auth::user()->id, $user_id_to_delete]);
        return response()->json(array('status' => 'success'));

      } catch(Exception $e) {
        return response()->json(array('status' => 'error'));
      }
    }


    /**
     * Cancel relationship request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function cancel_relationship_request(Request $request)
     {
       try {
         $requester_id = Auth::user()->id;
         $responder_id = $request->responder_id;

         $num_of_rows_affected = DB::delete("DELETE FROM relationships_users WHERE requester_id = ? AND responder_id = ? AND accepted = 0", [$requester_id, $responder_id]);
         if($num_of_rows_affected > 0) {
           if($request->ajax()) {
             return response()->json(array('status' => 'success'));
           }
           return redirect()->back()->with('success', 'Relationship request successfully cancelled.');
         }
         if($request->ajax()) {
           return response()->json(array('status' => 'error'));
         }
         return redirect()->back()->with('error', 'Relationship request could not be cancelled, please try again later.');
       } catch(Exception $e) {
         if($request->ajax()) {
           return response()->json(array('status' => 'error'));
         }
         return redirect()->back()->with('error', 'Relationship request could not be cancelled, please try again later.');
       }
     }

}
