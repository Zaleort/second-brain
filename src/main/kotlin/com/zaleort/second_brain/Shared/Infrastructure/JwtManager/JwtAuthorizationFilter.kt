package com.zaleort.second_brain.Shared.Infrastructure.JwtManager

import com.zaleort.second_brain.Shared.Domain.JwtManager.JwtManagerInterface
import io.jsonwebtoken.ExpiredJwtException
import jakarta.servlet.FilterChain
import jakarta.servlet.http.HttpServletRequest
import jakarta.servlet.http.HttpServletResponse
import org.springframework.security.authentication.UsernamePasswordAuthenticationToken
import org.springframework.security.core.context.SecurityContextHolder
import org.springframework.stereotype.Component
import org.springframework.web.filter.OncePerRequestFilter

@Component
class JwtAuthorizationFilter(
    private val jwtManager: JwtManagerInterface,
    private val userDetailsService: JwtUserDetailsService,
) : OncePerRequestFilter() {

    override fun shouldNotFilter(request: HttpServletRequest): Boolean {
        val path = request.requestURI
        return path == "/api/v1/login" || path.startsWith("/error")
    }

    override fun doFilterInternal(request: HttpServletRequest, response: HttpServletResponse, filterChain: FilterChain) {
        val authHeader = request.getHeader("Authorization")

        if (authHeader != null && authHeader.startsWith("Bearer ")) {
            val token = authHeader.substring(7)
            processToken(token, response)
        }

        filterChain.doFilter(request, response)
    }

    private fun processToken(token: String, response: HttpServletResponse) {
        try {
            // Intenta decodificar el token normalmente
            val payload = jwtManager.decode(token)
            authenticateUser(payload.id)
        } catch (e: ExpiredJwtException) {
            // Si el token ha expirado, intentamos renovarlo automáticamente
            try {
                // Extraer el ID del usuario del token expirado
                val userId = e.claims.subject

                // Autenticar al usuario con el ID extraído
                authenticateUser(userId)

                // Renovar el token
                val newToken = jwtManager.renewToken(token)

                // Añadir el nuevo token a la respuesta
                response.addHeader("Authorization", "Bearer $newToken")
                response.addHeader("Access-Control-Expose-Headers", "Authorization")

                println("Token renovado automáticamente para usuario: $userId")
            } catch (ex: Exception) {
                println("Error al renovar el token: ${ex.message}")
            }
        } catch (e: Exception) {
            println("Error procesando JWT: ${e.message}")
        }
    }

    private fun authenticateUser(userId: String) {
        val userDetails = userDetailsService.loadUserByUsername(userId)
        val authentication = UsernamePasswordAuthenticationToken(userDetails, null, userDetails.authorities)
        SecurityContextHolder.getContext().authentication = authentication
    }
}