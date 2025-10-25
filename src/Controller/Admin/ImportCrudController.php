<?php

namespace App\Controller\Admin;

use App\Entity\Import;
use App\Enum\ImportRecurrence;
use App\Enum\ImportSource;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ImportCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Import::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            ChoiceField::new('type')->setChoices(ImportSource::cases()),
            ChoiceField::new('recurrence')->setChoices(ImportRecurrence::cases()),
            TextField::new('SourcePath'),
            BooleanField::new('isActive'),
        ];
    }
    
}
