<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Address
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $address1
 * @property string|null $address2
 * @property string $zipcode
 * @property string $city
 * @property-read \App\Models\Company|null $company
 * @property-read \App\Models\School|null $school
 * @property-read \App\Models\Student|null $student
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Address newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Address newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Address query()
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereAddress1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereAddress2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereZipcode($value)
 */
	class Address extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Company
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $name
 * @property string|null $logo
 * @property int $address_id
 * @property-read \App\Models\Address $address
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tutor[] $tutors
 * @property-read int|null $tutors_count
 * @method static \Illuminate\Database\Eloquent\Builder|Company newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Company newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Company query()
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereAddressId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereUpdatedAt($value)
 */
	class Company extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Contact
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $firstname
 * @property string $lastname
 * @property string $function
 * @property string|null $phone
 * @property string $email
 * @property int $school_id
 * @property-read \App\Models\School|null $school
 * @method static \Illuminate\Database\Eloquent\Builder|Contact newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Contact newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Contact query()
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereFunction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereSchoolId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contact whereUpdatedAt($value)
 */
	class Contact extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Debrief
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $date
 * @property string $summary
 * @property int $student_id
 * @property int $tutor_id
 * @property int $contact_id
 * @property-read \App\Models\Contact|null $contact
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Document[] $documents
 * @property-read int|null $documents_count
 * @property-read \App\Models\Student|null $student
 * @property-read \App\Models\Tutor|null $tutor
 * @method static \Illuminate\Database\Eloquent\Builder|Debrief newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Debrief newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Debrief query()
 * @method static \Illuminate\Database\Eloquent\Builder|Debrief whereContactId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Debrief whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Debrief whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Debrief whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Debrief whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Debrief whereSummary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Debrief whereTutorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Debrief whereUpdatedAt($value)
 */
	class Debrief extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Diploma
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $name
 * @property int|null $user_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Scorecard[] $scorecards
 * @property-read int|null $scorecards_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SkillTemplate[] $skillTemplates
 * @property-read int|null $skill_templates_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Student[] $students
 * @property-read int|null $students_count
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Diploma newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Diploma newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Diploma query()
 * @method static \Illuminate\Database\Eloquent\Builder|Diploma whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Diploma whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Diploma whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Diploma whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Diploma whereUserId($value)
 */
	class Diploma extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\DiplomaSkillTemplate
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property int $skill_template_id
 * @property int $diploma_id
 * @property-read \App\Models\Diploma $diploma
 * @property-read \App\Models\SkillTemplate $skillTemplate
 * @method static \Illuminate\Database\Eloquent\Builder|DiplomaSkillTemplate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DiplomaSkillTemplate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DiplomaSkillTemplate query()
 * @method static \Illuminate\Database\Eloquent\Builder|DiplomaSkillTemplate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DiplomaSkillTemplate whereDiplomaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DiplomaSkillTemplate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DiplomaSkillTemplate whereSkillTemplateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DiplomaSkillTemplate whereUpdatedAt($value)
 */
	class DiplomaSkillTemplate extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\DiplomaStudent
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property string $state
 * @property string $start_year
 * @property string $end_year
 * @property int $diploma_id
 * @property int $student_id
 * @property-read \App\Models\Diploma $diploma
 * @property-read \App\Models\Student $student
 * @method static \Illuminate\Database\Eloquent\Builder|DiplomaStudent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DiplomaStudent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DiplomaStudent query()
 * @method static \Illuminate\Database\Eloquent\Builder|DiplomaStudent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DiplomaStudent whereDiplomaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DiplomaStudent whereEndYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DiplomaStudent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DiplomaStudent whereStartYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DiplomaStudent whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DiplomaStudent whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DiplomaStudent whereUpdatedAt($value)
 */
	class DiplomaStudent extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Document
 *
 * @property-read \App\Models\Debrief $debrief
 * @property-read \App\Models\Student $student
 * @property-read \App\Models\DocumentType|null $type
 * @method static \Illuminate\Database\Eloquent\Builder|Document newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Document newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Document query()
 */
	class Document extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\DocumentType
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $name
 * @property-read \App\Models\Debrief $debrief
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentType query()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentType whereUpdatedAt($value)
 */
	class DocumentType extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\School
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $name
 * @property string|null $logo
 * @property int $address_id
 * @property-read \App\Models\Address $address
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Contact[] $contacts
 * @property-read int|null $contacts_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Student[] $students
 * @property-read int|null $students_count
 * @method static \Illuminate\Database\Eloquent\Builder|School newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|School newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|School query()
 * @method static \Illuminate\Database\Eloquent\Builder|School whereAddressId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|School whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|School whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|School whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|School whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|School whereUpdatedAt($value)
 */
	class School extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Scorecard
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $name
 * @property int $diploma_id
 * @property int $student_id
 * @property int|null $user_id
 * @property-read \App\Models\Diploma $diploma
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Skill[] $skills
 * @property-read int|null $skills_count
 * @property-read \App\Models\Student $student
 * @property-read \App\Models\Tutor $tutor
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Scorecard newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Scorecard newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Scorecard query()
 * @method static \Illuminate\Database\Eloquent\Builder|Scorecard whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Scorecard whereDiplomaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Scorecard whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Scorecard whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Scorecard whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Scorecard whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Scorecard whereUserId($value)
 */
	class Scorecard extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ScorecardSkill
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon $created_at
 * @property string $state
 * @property int $skill_id
 * @property int $scorecard_id
 * @property-read \App\Models\Scorecard $scorecard
 * @property-read \App\Models\Skill $skill
 * @method static \Illuminate\Database\Eloquent\Builder|ScorecardSkill newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ScorecardSkill newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ScorecardSkill query()
 * @method static \Illuminate\Database\Eloquent\Builder|ScorecardSkill whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ScorecardSkill whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ScorecardSkill whereScorecardId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ScorecardSkill whereSkillId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ScorecardSkill whereState($value)
 */
	class ScorecardSkill extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Skill
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $name
 * @property int $skill_template_id
 * @property int|null $user_id
 * @property-read \App\Models\User $creator
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Scorecard[] $scorecards
 * @property-read int|null $scorecards_count
 * @property-read \App\Models\SkillTemplate $skillTemplate
 * @method static \Illuminate\Database\Eloquent\Builder|Skill newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Skill newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Skill query()
 * @method static \Illuminate\Database\Eloquent\Builder|Skill whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Skill whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Skill whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Skill whereSkillTemplateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Skill whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Skill whereUserId($value)
 */
	class Skill extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\SkillTemplate
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $name
 * @property int|null $user_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Diploma[] $diplomas
 * @property-read int|null $diplomas_count
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|SkillTemplate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SkillTemplate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SkillTemplate query()
 * @method static \Illuminate\Database\Eloquent\Builder|SkillTemplate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SkillTemplate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SkillTemplate whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SkillTemplate whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SkillTemplate whereUserId($value)
 */
	class SkillTemplate extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Student
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $school_id
 * @property int $company_id
 * @property int $tutor_id
 * @property int $user_id
 * @property int $address_id
 * @property-read \App\Models\Address $address
 * @property-read \App\Models\Company $company
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Debrief[] $debriefs
 * @property-read int|null $debriefs_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Diploma[] $diplomas
 * @property-read int|null $diplomas_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Document[] $documents
 * @property-read int|null $documents_count
 * @property-read \App\Models\School $school
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Scorecard[] $scorecards
 * @property-read int|null $scorecards_count
 * @property-read \App\Models\Tutor $tutor
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Student newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Student newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Student query()
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereAddressId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereSchoolId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereTutorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Student whereUserId($value)
 */
	class Student extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Tutor
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $company_id
 * @property int $user_id
 * @property-read \App\Models\Company $company
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Debrief[] $debriefs
 * @property-read int|null $debriefs_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Scorecard[] $scorecards
 * @property-read int|null $scorecards_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Student[] $students
 * @property-read int|null $students_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Tutor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tutor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tutor query()
 * @method static \Illuminate\Database\Eloquent\Builder|Tutor whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tutor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tutor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tutor whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tutor whereUserId($value)
 */
	class Tutor extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string|null $password
 * @property bool $is_admin
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $firstname
 * @property string $lastname
 * @property string|null $phone
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \App\Models\Student|null $student
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @property-read \App\Models\Tutor|null $tutor
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

