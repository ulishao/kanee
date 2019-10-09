<?php
/**
 * Created by PhpStorm.
 * User: hhx
 * Date: 2019/5/6
 * Time: 16:08
 */

namespace App\Libs;


use App\Models\Student;
use App\Models\TimetableDetail;

class VirtualStudentTag
{
    /** @var \App\Models\Student[]|\Illuminate\Database\Eloquent\Collection|mixed */
    protected $studentTag;
    protected $timetableDetail = [];
    protected $temporary = [];
    protected $leave = [];
    protected $student = [];


    /**
     * VirtualStudentTag constructor.
     * @param TimetableDetail $timetableDetail
     */
    public function __construct ( TimetableDetail $timetableDetail )
    {
        $this->timetableDetail = $timetableDetail;
        $this->studentTag = $timetableDetail->tag->students->load ('membershipCard:student_id,card_number');
        foreach ($timetableDetail->timetableDetailTemporary ()->with ('student', 'student.contacts', 'student.membershipCard:student_id,card_number')->get () as $timetableDetailTemporary) {
            if ( $timetableDetailTemporary->student ) {
                switch ($timetableDetailTemporary->status) {
                    case 1:
                        $timetableDetailTemporary->student->offsetSet ('tagType', 1);
                        $this->temporary[] = $timetableDetailTemporary->student;
                        $this->student[] = $timetableDetailTemporary->student->toArray ();
                        break;
                    case 2:
                        $timetableDetailTemporary->student->offsetSet ('tagType', 2);
                        $this->leave[] = $timetableDetailTemporary->student;
                        $this->student[] = $timetableDetailTemporary->student->toArray ();
                        break;
                    default:
                        break;
                }
            }
        }
        //$this->temporary=collect($this->temporary);
        //$this->leave=collect($this->leave);
        $this->studentTag = $this->studentTag->diff ($this->leave);
        foreach ($this->studentTag as $tiem) {
            $tiem->offsetSet ('tagType', 3);
            $tiem->offsetUnset ('pivot');
            $this->student[] = $tiem->toArray ();
        }
        $this->handle ();
    }

    /**
     * @return array
     */
    public function handle ()
    {

        return $this->student;
        //$this->studentTag = collect(array_merge($this->temporary,$this->leave));

//        $this->studentTag->transform(function ($student) {
////            dd($this->timetableDetailTemporary->where('organization_id','=',1)->first());
//            /** @var Student $student */
////            $student[] = $this->temporary;
////            $student[] = $this->leave;
//            return $student;
//        });
    }

}