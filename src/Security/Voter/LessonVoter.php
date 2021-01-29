<?php

namespace App\Security\Voter;

use App\Entity\Lesson;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class LessonVoter extends Voter
{
    protected function supports($attribute, $subject)
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [ 'LESSON_VIEW'])
            && $subject instanceof Lesson;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {

            case 'LESSON_VIEW':
                 $userCourses = $user->getUserCourses();

                 foreach ($userCourses as $userCourse){

                     if($subject->getCourse() === $userCourse->getCourse()){
                         return true;
                     }

                 }
                 return false;

                // logic to determine if the user can VIEW
                // return true or false
                break;
        }

        throw new \Exception(sprintf('Unhandled attribute "%s"', $attribute));
    }
}
