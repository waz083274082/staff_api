<?php
namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Http\Request;
use App\Http\Resources\StaffResource;

/**
 * @OA\OpenApi(
 *   @OA\Info(
 *     title="Staff API",
 *     version="1.0.0",
 *     description="A simple example Laravel API to manage staff records",
 *     @OA\Contact(
 *       email="warren.nelson@gmail.com",
 *       name="Warren Nelson"
 *     )
 *   )
 * )

 * @OA\Schema(
 *     schema="Staff",
 *     type="object",
 *     title="Staff Model",
 *     properties={
 *         @OA\Property(property="id", type="integer"),
 *         @OA\Property(property="email", type="string"),
 *         @OA\Property(property="first_name", type="string"),
 *         @OA\Property(property="last_name", type="string"),
 *         @OA\Property(property="status", type="string"),
 *         @OA\Property(property="squad", type="string"),
 *         @OA\Property(property="start_date", type="string", format="date"),
 *         @OA\Property(property="notes", type="string"),
 *     }
 * )
 */

class StaffController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/staff",
     *     summary="Lists all staff members",
     *     @OA\Response(
     *         response=200,
     *         description="A list of staff members",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Staff")
     *         )
     *     )
     * )
     */
    public function index()
    {
        $staff = Staff::all();
        return StaffResource::collection($staff);
    }

    /**
     * @OA\Post(
     *     path="/api/staff",
     *     summary="Creates a new staff member",
     *     @OA\RequestBody(
     *         description="Staff member to add",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Staff")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Staff member created",
     *         @OA\JsonContent(ref="#/components/schemas/Staff")
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:staff,email',
            'password' => 'required|min:8',
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'status' => 'required|in:Active,Inactive',
            'squad' => 'required|in:squad1,squad2,squad3,squad4,squad5,NA',
            'start_date' => 'required|date',
            'notes' => 'nullable',
        ]);

        // Hash the password before saving
        $validated['password'] = bcrypt($validated['password']);

        $staff = Staff::create($validated);
        return new StaffResource($staff);
    }

    /**
     * @OA\Get(
     *     path="/api/staff/{id}",
     *     summary="Retrieves a specific staff member by id",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the staff member to retrieve",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Staff member retrieved",
     *         @OA\JsonContent(ref="#/components/schemas/Staff")
     *     )
     * )
     */
    public function show($id)
    {
        $staff = Staff::findOrFail($id);
        return new StaffResource($staff);
    }

    /**
     * @OA\Put(
     *     path="/api/staff/{id}",
     *     summary="Updates a specific staff member by id",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the staff member to update",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         description="Data to update the staff member with",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Staff")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Staff member updated",
     *         @OA\JsonContent(ref="#/components/schemas/Staff")
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $staff = Staff::findOrFail($id);

        $validated = $request->validate([
            'email' => 'email|unique:staff,email,' . $id,
            'first_name' => 'max:255',
            'last_name' => 'max:255',
            'status' => 'in:Active,Inactive',
            'squad' => 'in:squad1,squad2,squad3,squad4,squad5,NA',
            'start_date' => 'date',
            'notes' => 'nullable',
        ]);

        $staff->update($validated);
        return new StaffResource($staff);
    }

    /**
     * @OA\Delete(
     *     path="/api/staff/{id}",
     *     summary="Deletes a specific staff member by id",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the staff member to delete",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Staff member deleted"
     *     )
     * )
     */
    public function destroy($id)
    {
        $staff = Staff::findOrFail($id);
        $staff->delete();
        return response()->json(null, 204);
    }
}
