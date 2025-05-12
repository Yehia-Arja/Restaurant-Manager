import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:mobile/core/theme/colors.dart';
import 'package:mobile/features/products/domain/entities/product.dart';
import 'package:mobile/features/products/domain/usecases/get_product_detail_usecase.dart';
import 'package:mobile/features/products/presentation/bloc/product_detail_bloc.dart';
import 'package:mobile/features/products/presentation/bloc/product_detail_event.dart';
import 'package:mobile/features/products/presentation/bloc/product_detail_state.dart';

class ProductDetailPage extends StatelessWidget {
  final int productId;
  const ProductDetailPage({super.key, required this.productId});

  @override
  Widget build(BuildContext context) {
    return BlocProvider(
      create:
          (_) =>
              ProductDetailBloc(context.read<GetProductDetailUseCase>())
                ..add(LoadProductDetail(productId)),
      child: BlocBuilder<ProductDetailBloc, ProductDetailState>(
        builder: (ctx, state) {
          if (state is DetailLoading) {
            return const Scaffold(body: Center(child: CircularProgressIndicator()));
          }
          if (state is DetailError) {
            return Scaffold(body: Center(child: Text(state.message)));
          }
          final Product p = (state as DetailLoaded).product;
          return Scaffold(
            body: SingleChildScrollView(
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.stretch,
                children: [
                  // top image, fixed height
                  SizedBox(
                    height: 200,
                    width: double.infinity,
                    child: Image.network(p.imageUrl, fit: BoxFit.cover),
                  ),

                  const SizedBox(height: 12),

                  // rest content with 20px padding
                  Padding(
                    padding: const EdgeInsets.symmetric(horizontal: 20),
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Text(p.name, style: Theme.of(context).textTheme.headlineSmall),
                        const SizedBox(height: 8),
                        Text(p.description, style: Theme.of(context).textTheme.bodyMedium),
                        const SizedBox(height: 16),
                        Row(
                          children: [
                            const Icon(Icons.access_time, size: 16, color: AppColors.accent),
                            const SizedBox(width: 6),
                            Text(p.timeToDeliver, style: Theme.of(context).textTheme.bodySmall),
                            const SizedBox(width: 16),
                            Text(p.price, style: Theme.of(context).textTheme.bodySmall),
                          ],
                        ),
                        const SizedBox(height: 24),

                        // Confirm Order button
                        SizedBox(
                          width: double.infinity,
                          height: 48,
                          child: ElevatedButton(
                            onPressed: () {
                              // TODO: confirm order action
                            },
                            child: const Text('Confirm Order'),
                          ),
                        ),

                        const SizedBox(height: 20),
                      ],
                    ),
                  ),
                ],
              ),
            ),
          );
        },
      ),
    );
  }
}
