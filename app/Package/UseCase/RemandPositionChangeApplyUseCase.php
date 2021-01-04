<?php


namespace App\Package\UseCase;


use App\Package\Domain\PositionChangeApply\PositionChangeApplyRepository;
use Illuminate\Support\Facades\DB;

class RemandPositionChangeApplyUseCase
{
    /** @var PositionChangeApplyRepository */
    private $positionChangeRepository;

    /**
     * ApplyPositionChangeApplyUseCase constructor.
     * @param PositionChangeApplyRepository $positionChangeApplyRepository
     */
    public function __construct( PositionChangeApplyRepository $positionChangeApplyRepository )
    {
        $this->positionChangeRepository = $positionChangeApplyRepository;
    }

    public function execute()
    {
        DB::beginTransaction();

        try {

            /**
             * Step1.　役職変更申請の取得
             */
            $positionChangeApply = $this->positionChangeRepository->find( 6 );

            /**
             * Step2.　差戻する
             */
            $positionChangeApply->doRemand();
            if ( !$this->positionChangeRepository->save( $positionChangeApply ) ){
                throw new \Exception( '役職変更申請の差戻に失敗しました' );
            }

            DB::commit();

        } catch ( \UnexpectedValueException $e) {

        } catch ( \Exception $e) {

        } finally {
            DB::rollBack();
        }
    }
}
