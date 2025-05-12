import 'package:flutter_bloc/flutter_bloc.dart';
import 'product_detail_event.dart';
import 'product_detail_state.dart';
import 'package:mobile/features/products/domain/usecases/get_product_detail_usecase.dart';

class ProductDetailBloc extends Bloc<ProductDetailEvent, ProductDetailState> {
  final GetProductDetailUseCase _uc;

  ProductDetailBloc(this._uc) : super(DetailLoading()) {
    on<LoadProductDetail>((event, emit) async {
      emit(DetailLoading());
      try {
        final p = await _uc(event.productId);
        emit(DetailLoaded(p));
      } catch (err) {
        emit(DetailError(err.toString()));
      }
    });
  }
}
