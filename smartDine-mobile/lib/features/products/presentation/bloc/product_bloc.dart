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
    try {
      final isFirstPage = event.page == 1;

      if (isFirstPage) {
        emit(ProductLoading());
      } else if (state is ProductLoaded) {
        final current = state as ProductLoaded;
        emit(
          ProductLoaded(
            products: current.products,
            currentPage: current.currentPage,
            totalPages: current.totalPages,
            isFetchingMore: true,
          ),
        );
      }

      final result = await _listUseCase.call(
        branchId: event.branchId,
        searchQuery: event.searchQuery,
        categoryId: event.categoryId,
        favoritesOnly: event.favoritesOnly,
        page: event.page,
      );

      final newProducts = result.products;
      final totalPages = result.totalPages;

      if (state is ProductLoaded && !isFirstPage) {
        final previous = state as ProductLoaded;
        emit(
          ProductLoaded(
            products: [...previous.products, ...newProducts],
            currentPage: event.page,
            totalPages: totalPages,
          ),
        );
      } else {
        emit(ProductLoaded(products: newProducts, currentPage: event.page, totalPages: totalPages));
      }
    } catch (e) {
      emit(ProductError(e.toString()));
    }
  }
}
