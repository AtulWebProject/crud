<?php
use lsolesen\pel\PelJpeg;
use lsolesen\pel\PelTag;
use lsolesen\pel\PelEntryAscii;


            $pelJpeg = new PelJpeg(Yii::getAlias('@str-set') . "F:\xampp\htdocs\seoimage\img/$this->t.jpg");

            $pelExif = $pelJpeg->getExif();

            if ($pelExif == null) {
                $pelExif = new PelExif();
                $pelJpeg->setExif($pelExif);
            }
            $pelTiff = $pelExif->getTiff();
            if ($pelTiff == null) {
                $pelTiff = new PelTiff();
                $pelExif->setTiff($pelTiff);
            }

            $pelIfd0 = $pelTiff->getIfd();
            if ($pelIfd0 == null) {
                $pelIfd0 = new PelIfd(PelIfd::IFD0);
                $pelTiff->setIfd($pelIfd0);
            }
            $pelIfd0->addEntry(new PelEntryAscii(
                    PelTag::IMAGE_DESCRIPTION, $this->description
                )
            );
            $pelIfd0->addEntry(new PelEntryAscii(
                    PelTag::XP_TITLE, $this->title
                )
            );

            $keywords = [];
            foreach ($this->keywords as $keyword)
                $keywords[] = $keyword->title;

            $kw_string = implode(", ", $keywords);
            $pelIfd0->addEntry(new PelEntryAscii(
                    PelTag::XP_KEYWORDS, $kw_string
                )
            );

            $pelJpeg->saveFile(Yii::getAlias('@str-set') . "F:\xampp\htdocs\seoimage\img/$this->t.jpg");

?><?php /**PATH F:\xampp\htdocs\seo\resources\views/exif.blade.php ENDPATH**/ ?>