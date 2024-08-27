<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Container\Attributes\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\JsonResponse;
class PatientController extends Controller
{


    public function index(Request $request): JsonResponse
    {
        $user = $request->user();

        $appointments = $user->patient->get();

        return response()->json($appointments);
    }


    public function create()
    {
        $doctors = Doctor::all();

        $departments = Department::all();
        return response()->json([
            'doctors' => $doctors,
            'departments' => $departments
        ]);
    }

    /**
     * @OA\Post(
     *     path="/patients",
     *     summary="Create a new patient",
     *     tags={"Patient"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"address","number","age","birth_date","gender"},
     *             @OA\Property(property="address", type="string", example="pkr"),
     *             @OA\Property(property="number", type="integer", example=122),
     *             @OA\Property(property="age", type="integer", example=22),
     *             @OA\Property(property="birth_date", type="string", format="date", example="2020-01-02"),
     *             @OA\Property(property="gender", type="string", enum={"male","female","others"}, example="male"),
     *             @OA\Property(property="description", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Patient created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Patient")
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Unauthorized patient"
     *     )
     * )
     */

    public function store(Request $request)
    {
        //
        $validatedData = $request->validate([
            'address' => 'required|string|max:100',
            'number' => 'required|string',
            'age' => 'required|integer',
            'birth_date' => 'required|date',
            'gender' => 'required|in:male,female,others',
            'description' => 'nullable|string'
        ]);

        $patient = Patient::create([
            // 'user_id' => Auth::user()->id,
            'user_id' => $request->user()->id,
            'address' => $validatedData['address'],
            'number' => $validatedData['number'],
            'age' => $validatedData['age'],
            'birth_date' => $validatedData['birth_date'],
            'gender' => $validatedData['gender'],
            'description' => $validatedData['description']
        ]);


        return response()->json(['message' => 'patient created', 'patient' => $patient], 201);
    }
   
      public function show(string $id)
    {
        //
        $appointment = Appointment::with('doctor', 'department')->findOrFail($id);

        // // Optionally, check if the appointment belongs to the authenticated patient
        // if (Auth::user()->patient->id != $appointment->patient_id) {
        //     return response()->json(['error' => 'Unauthorized'], 403);
        // }

        //return response()->json($appointment);
        return response()->json(['message' => 'patient show', 'patient' => $appointment], 201);
    }
 public function edit(int $id): JsonResponse
{
    $patient = Patient::findOrFail($id);
    return response()->json($patient);
}
    /**
     * @OA\Put(
     *     path="/patients/{id}",
     *     summary="Update patient details",
     *     tags={"Patient"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the patient",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"address","number","age","birth_date","gender"},
     *             @OA\Property(property="address", type="string", example="pkr"),
     *             @OA\Property(property="number", type="string", example="122"),
     *             @OA\Property(property="age", type="integer", example=22),
     *             @OA\Property(property="birth_date", type="string", format="date", example="2020-01-02"),
     *             @OA\Property(property="gender", type="string", enum={"male","female","others"}, example="male"),
     *             @OA\Property(property="description", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Patient updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Patient")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Patient not found"
     *     )
     * )
     */

    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'address' => 'required|string|max:100',
            'number' => 'required|numeric',
            'age' => 'required|integer',
            'birth_date' => 'required|date',
            'gender' => 'required|in:female,male,others',
            'description' => 'nullable|string'
        ]);

        $patient = Patient::findOrFail($id);
        $patient->update($validatedData);
        // return redirect()->route('patient.index');
        //    return response()->json($patient);
        return response()->json(['message' => 'patient updated', 'patient' => $patient], 201);
    }
   /**
 * @OA\Delete(
 *     path="/patients/{id}",
 *     summary="Cancel an appointment",
 *     tags={"Patient"},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID of the appointment",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Appointment canceled successfully",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="success", type="string", example="Appointment canceled successfully!")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Appointment not found"
 *     )
 * )
 */
    public function destroy(string $id)
    {
        $appointment = Appointment::find($id);

        if ($appointment) {
            $appointment->delete();
            return response()->json(['success' => 'Appointment canceled successfully!']);
        }

        return response()->json(['error' => 'Appointment not found.'], 404);
    }


    public function showAvailableSchedules()
    {
        $schedules = Schedule::all();
        return response()->json($schedules);
    }
}
