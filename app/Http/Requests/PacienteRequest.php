<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PacienteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Permitir siempre; puedes agregar lógica si necesitas roles
    }

    public function rules(): array
    {
        $pacienteId = $this->route('paciente')->id ?? null;
        return [
            // Datos personales
            'nombre'               => ['required', 'string', 'max:150'],
            'apellido_paterno'     => ['required', 'string', 'max:150'],
            'apellido_materno'     => ['nullable', 'string', 'max:150'],
            'curp' => 'nullable|string|max:18|unique:pacientes,curp,' . $pacienteId,
            //'sexo'                 => ['required', 'in:H,M'],
            'fecha_nacimiento'     => ['required', 'date', 'before:today'],
            'fecha_inicio'         => ['nullable', 'date'],

            // Contacto
            //'telefono'             => ['nullable', 'string', 'max:20'],
            //'correo'               => ['nullable', 'email', 'max:150'],

            // Datos sociales
            'estado_civil_id'      => ['nullable', 'integer', 'exists:edo_civil,id'],
            'ocupacion_id'         => ['nullable', 'integer', 'exists:ocupaciones,id'],
            'escolaridad_id'       => ['nullable', 'integer', 'exists:escolaridad,id'],

            // Direccion
            'direccion'            => ['nullable', 'string', 'max:255'],
            'ciudad'               => ['nullable', 'string', 'max:150'],
            'estado'               => ['nullable', 'string', 'max:150'],

            // Expediente socioeconómico
            //'ingreso_matutino'     => ['nullable', 'numeric', 'min:0'],
            //'ingreso_vespertino'   => ['nullable', 'numeric', 'min:0'],
            //'ingreso_total'        => ['nullable', 'numeric', 'min:0'],

            // Egresos
            //'egreso_alimentacion'  => ['nullable', 'numeric', 'min:0'],
            //'egreso_renta'         => ['nullable', 'numeric', 'min:0'],
            //'egreso_servicios'     => ['nullable', 'numeric', 'min:0'],

            // Historial clínico inicial
            //'peso'                 => ['nullable', 'numeric', 'min:0', 'max:700'],
            //'estatura'             => ['nullable', 'numeric', 'min:0', 'max:3'],
            //'tipo_sangre_id'       => ['nullable', 'integer', 'exists:tipos_sangre,id'],

            // Cirugías previas (array)
            'cirugia_tipo'         => ['nullable', 'array'],
            'cirugia_tipo.*'       => ['nullable', 'integer', 'exists:cirugia_tipos,id'],

            'cirugia_fecha'        => ['nullable', 'array'],
            'cirugia_fecha.*'      => ['nullable', 'date'],

            'cirugia_notas'        => ['nullable', 'array'],
            'cirugia_notas.*'      => ['nullable', 'string', 'max:500'],

            // Otros datos médicos
            //'alergias'             => ['nullable', 'string', 'max:500'],
            //'enfermedades'         => ['nullable', 'string', 'max:500'],
            //'medicamentos'         => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre es obligatorio.',
            'apellido_paterno.required' => 'El apellido paterno es obligatorio.',
            'fecha_nacimiento.before' => 'La fecha de nacimiento debe ser anterior a hoy.',
            'correo.email' => 'Debe ingresar un correo electrónico válido.',
            'estado_civil_id.exists' => 'Seleccione un estado civil válido.',
            'ocupacion_id.exists' => 'Seleccione una ocupación válida.',
            'escolaridad_id.exists' => 'Seleccione una escolaridad válida.',
            'tipo_sangre_id.exists' => 'Seleccione un tipo de sangre válido.',
            'cirugia_tipo.*.exists' => 'Una de las cirugías no es válida.',
        ];
    }
}
