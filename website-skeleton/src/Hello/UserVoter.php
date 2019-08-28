<?php

namespace App\Hello;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class UserVoter extends Voter {

    const DELETE = 'deleteOrder';
    const UPDATE = 'updateOrder';

    protected function supports($attribute, $subject)
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, [self::DELETE, self::UPDATE])) {
            return false;
        }

        // only vote on Post objects inside this voter
        if (!$subject instanceof User) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            // the user must be logged in; if not, deny access
            return false;
        }

        // you know $subject is a Post object, thanks to supports
        /** @var Post $post */
        $post = $subject;

        switch ($attribute) {
            case self::DELETE:
                return $this->canDelete($post, $user);
            case self::UPDATE:
                return $this->canUpdate($post, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canDelete(User $user)
    {
        
        return $user === $user->getUser();
    }

    private function canUpdate(user $user)
    {
        // this assumes that the data object has a getOwner() method
        // to get the entity of the user who owns this data object
        return $user === $user->getUser();
    }
}

}