import 'package:flutter_bloc/flutter_bloc.dart';
import 'product_event.dart';
import 'product_state.dart';
import 'package:mobile/features/products/domain/usecases/list_products_usecase.dart';

class ProductBloc extends Bloc<ProductEvent, ProductState> {
  final ListProductsUseCase _listUseCase;

  ProductBloc(this._listUseCase) : super(ProductInitial()) {
    on<LoadProducts>(_onLoadProducts);
  }

  Future<void> _onLoadProducts(LoadProducts event, Emitter<ProductState> emit) async {
    emit(ProductLoading());
    try {
      final products = await _listUseCase.call(event.branchId);
      emit(ProductLoaded(products));
    } catch (e) {
      emit(ProductError(e.toString()));
    }
  }
}
